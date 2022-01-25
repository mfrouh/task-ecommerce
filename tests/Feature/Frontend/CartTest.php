<?php

namespace Tests\Feature\Frontend;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'Admin']);
        $this->customer = User::factory()->create(['role' => 'Customer']);
        $this->actingAs($this->customer);
        $this->customer2 = User::factory()->create(['role' => 'Customer']);
        Category::factory()->create();
    }

    public function test_get_auth_cart_content()
    {
        Cart::factory(5)->create(['user_id' => $this->customer->id]);

        $this->json('get', route('getCart'))
            ->assertJsonPath('0.total_price', Cart::content()[0]->total_price)
            ->assertJsonCount(5)
            ->assertSuccessful();

        Cart::factory(7)->create(['user_id' => $this->customer2->id]);

        $this->actingAs($this->customer2);

        $this->json('get', route('getCart'))
            ->assertJsonPath('0.total_price', Cart::content()[0]->total_price)
            ->assertJsonCount(7)
            ->assertSuccessful();

    }

    public function test_add_or_update_product_to_cart()
    {
        $product = Product::factory()->create();

        $product2 = Product::factory()->create();

        $product3 = Product::factory()->create();

        $this->json('post', route('cart.store', ['product_id' => $product->id, 'quantity' => 3]))
            ->assertSuccessful();

        $this->json('post', route('cart.store', ['product_id' => $product->id]))
            ->assertSuccessful();

        $this->json('post', route('cart.store', ['product_id' => $product3->id]))
            ->assertSuccessful();

        $this->assertDatabaseHas('carts', ['product_id' => $product->id, 'quantity' => 4]);
        $this->assertEquals(Cart::content()->count(), 2);

        $this->actingAs($this->customer2);

        $this->json('post', route('cart.store', ['product_id' => $product->id, 'quantity' => 2]))
            ->assertSuccessful();

        $this->json('post', route('cart.store', ['product_id' => $product2->id, 'quantity' => 8]))
            ->assertSuccessful();

        $this->json('post', route('cart.store', ['product_id' => $product3->id, 'quantity' => 5]))
            ->assertSuccessful();

        $this->assertEquals(Cart::content()->count(), 3);
    }

    public function test_customer_can_delete_product_from_cart()
    {
        $product = Product::factory()->create();

        $this->json('post', route('cart.store', ['product_id' => $product->id, 'quantity' => 2]))
            ->assertSuccessful();

        $this->json('delete', route('cart.destroy', [Cart::content()[0]->id]))
            ->assertSuccessful();

        $this->assertEquals(Cart::content()->count(), 0);
    }

    public function test_customer_can_clear_cart()
    {
        $product = Product::factory()->create();

        $this->json('post', route('cart.store', ['product_id' => $product->id, 'quantity' => 2]))
            ->assertSuccessful();

        $this->json('delete', route('cart.clear'))
            ->assertSuccessful();

        $this->assertEquals(Cart::content()->count(), 0);

        $this->actingAs($this->customer2);

        Cart::factory(7)->create(['user_id' => $this->customer2->id]);
        Cart::factory(6)->create(['user_id' => $this->customer->id]);

        $this->assertEquals(Cart::content()->count(), 7);

        $this->json('delete', route('cart.clear'))
            ->assertSuccessful();

        $this->assertEquals(Cart::content()->count(), 0);
        $this->assertDatabaseCount('carts', 6);
    }

    public function test_quantity_in_cart()
    {
        $product = Product::factory()->create();

        $product2 = Product::factory()->create();

        $product3 = Product::factory()->create();

        $this->json('post', route('cart.store', ['product_id' => $product->id, 'quantity' => 3]))
            ->assertSuccessful();

        $this->json('post', route('cart.store', ['product_id' => $product->id]))
            ->assertSuccessful();

        $this->json('post', route('cart.store', ['product_id' => $product3->id]))
            ->assertSuccessful();

        $this->assertDatabaseHas('carts', ['product_id' => $product->id, 'quantity' => 4]);
        $this->assertEquals(Cart::content()->count(), 2);

        $this->json('post', route('cart.store', ['product_id' => $product3->id, 'quantity' => 0]))
            ->assertJsonPath('message', 'Success Delete Item In Cart')
            ->assertSuccessful();

        $this->assertEquals(Cart::content()->count(), 1);

        $this->json('post', route('cart.store', ['product_id' => $product2->id, 'quantity' => 0]))
            ->assertJsonPath('message', 'Quantity Cannot Be 0');

        $this->assertEquals(Cart::content()->count(), 1);
    }
}
