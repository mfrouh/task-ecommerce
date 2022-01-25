<?php

namespace Tests\Feature\Backend;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'Admin']);
        $this->customer = User::factory()->create(['role' => 'Customer']);
        $this->actingAs($this->admin);
    }

    public function test_admin_can_get_all_categories()
    {
        Category::factory(5)->create();

        $this->json('get', route('backend.category.getData'))
            ->assertJsonCount(5, 'data')
            ->assertSuccessful();
    }

    public function test_admin_can_create_category()
    {
        $this->json('post', route('backend.category.store'), ['name' => 'new category'])
            ->assertCreated();

        $this->assertDatabaseHas('categories', ['name' => 'new category', 'slug' => 'new-category']);
    }

    public function test_admin_cannot_create_category()
    {
        $this->json('post', route('backend.category.store'), ['name' => ''])
            ->assertJsonValidationErrors(['name']);

        $this->json('post', route('backend.category.store'), ['status' => 'wrong status'])
            ->assertJsonValidationErrors(['status']);

        $this->assertDatabaseCount('categories', 0);
    }

    public function test_admin_can_show_category()
    {
        $category = Category::factory()->create();

        $this->json('get', route('backend.category.show', [$category->id]))
            ->assertJsonPath('slug', $category->slug)
            ->assertSuccessful();
    }

    public function test_admin_cannot_show_category()
    {
        $category = Category::factory()->create();

        $this->json('get', route('backend.category.show', [$category->id + 1]))
            ->assertNotFound();
    }

    public function test_admin_can_update_category()
    {
        $category = Category::factory()->create();

        $this->json('put', route('backend.category.update', [$category->id]),
            ['name' => 'change category'])
            ->assertSuccessful();

        $this->assertDatabaseHas('categories', ['name' => 'change category', 'slug' => 'change-category']);
    }

    public function test_admin_cannot_update_category()
    {
        $category = Category::factory()->create(['name' => 'category']);

        $this->json('put', route('backend.category.update', [$category->id]),
            ['name' => ''])
            ->assertJsonValidationErrors('name');

        $this->json('put', route('backend.category.update', [$category->id]),
            ['status' => 'invalid value'])
            ->assertJsonValidationErrors('status');

        $this->assertDatabaseHas('categories', ['name' => 'category']);
    }

    public function test_admin_can_delete_category()
    {
        $category = Category::factory()->create();

        $this->json('delete', route('backend.category.destroy', [$category->id]))
            ->assertSuccessful();

        $this->assertDatabaseCount('categories', 0);
    }

    public function test_admin_cannot_delete_category()
    {
        $category = Category::factory()->create();

        $this->json('delete', route('backend.category.destroy', [$category->id + 1]))
            ->assertNotFound();

        $this->assertDatabaseCount('categories', 1);
    }

    public function test_customer_cannot_use_category_routes()
    {
        $this->actingAs($this->customer);

        $this->json('get', route('backend.category.index'))
            ->assertForbidden();

        $this->json('post', route('backend.category.store'), ['name' => 'new category'])
            ->assertForbidden();

        $category = Category::factory()->create();

        $this->json('get', route('backend.category.show', [$category->id]))
            ->assertForbidden();

        $this->json('put', route('backend.category.update', [$category->id]), ['name' => 'change category'])
            ->assertForbidden();

        $this->json('delete', route('backend.category.destroy', [$category->id]))
            ->assertForbidden();
    }

}
