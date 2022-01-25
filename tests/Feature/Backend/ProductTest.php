<?php

namespace Tests\Feature\Backend;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'Admin']);
        $this->customer = User::factory()->create(['role' => 'Customer']);
        $this->actingAs($this->admin);
        Storage::fake('public');
        $this->data = [
            'name' => 'Product 1', 'price' => 500,
            'image' => UploadedFile::fake()->image('avatar.png'), 'quantity' => 4,
            'status' => 1, 'description' => $this->faker->text, 'category_id' => Category::factory()->create()->id,
        ];
        $this->test_data = ['name' => '', 'price' => 'string value',
            'image' => 'string value', 'quantity' => 'string value',
            'status' => 'wrong value', 'description' => '', 'category_id' => 8,
        ];
    }

    public function test_admin_can_get_all_products()
    {
        Product::factory(5)->create();

        $this->json('get', route('backend.product.getData'))
            ->assertJsonCount(5, 'data')
            ->assertSuccessful();
    }

    public function test_admin_can_create_product()
    {
        $this->json('post', route('backend.product.store'), $this->data)->assertCreated();

        $this->assertDatabaseHas('products', ['name' => $this->data['name']]);
    }

    public function test_admin_cannot_create_product()
    {
        foreach ($this->test_data as $key => $value) {
            $this->json('post', route('backend.product.store'), [$key => $value] + $this->data)
                ->assertJsonValidationErrors($key);
        }

        $this->assertDatabaseCount('products', 0);
    }

    public function test_admin_can_show_product()
    {
        $product = Product::factory()->create();

        $this->json('get', route('backend.product.show', [$product->id]))
            ->assertJsonPath('slug', $product->slug)
            ->assertSuccessful();
    }

    public function test_admin_cannot_show_product()
    {
        $product = Product::factory()->create();

        $this->json('get', route('backend.product.show', [$product->id + 1]))
            ->assertNotFound();
    }

    public function test_admin_can_update_product()
    {
        $product = Product::factory()->create();

        $this->json('put', route('backend.product.update', [$product->id]), $this->data)->assertSuccessful();

        $this->assertDatabaseHas('products', ['name' => $this->data['name']]);
    }

    public function test_admin_cannot_update_product()
    {
        $product = Product::factory()->create();

        foreach ($this->test_data as $key => $value) {
            $this->json('put', route('backend.product.update', [$product->id]), [$key => $value] + $this->data)
                ->assertJsonValidationErrors($key);
        }

        $this->assertDatabaseHas('products', ['name' => $product->name]);
    }

    public function test_admin_can_delete_product()
    {
        $product = Product::factory()->create();

        $this->json('delete', route('backend.product.destroy', [$product->id]))
            ->assertSuccessful();

        $this->assertDatabaseCount('products', 0);
    }

    public function test_admin_cannot_delete_product()
    {
        $product = Product::factory()->create();

        $this->json('delete', route('backend.product.destroy', [$product->id + 1]))
            ->assertNotFound();

        $this->assertDatabaseCount('products', 1);
    }

    public function test_customer_cannot_use_product_routes()
    {
        $this->actingAs($this->customer);

        $this->json('get', route('backend.product.index'))
            ->assertForbidden();

        $this->json('post', route('backend.product.store'), $this->data)
            ->assertForbidden();

        $product = Product::factory()->create();

        $this->json('get', route('backend.product.show', [$product->id]))
            ->assertForbidden();

        $this->json('put', route('backend.product.update', [$product->id]), $this->data)
            ->assertForbidden();

        $this->json('delete', route('backend.product.destroy', [$product->id]))
            ->assertForbidden();

    }

}
