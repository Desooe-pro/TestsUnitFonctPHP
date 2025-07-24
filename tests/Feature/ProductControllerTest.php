<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use App\Http\Controllers\ProductController;

class ProductControllerTest extends TestCase {
    use RefreshDatabase;

    // Routes d'affichage
    public function testRouteIndex() {
        $response = $this->get("/products");
        $response->assertStatus(200);
    }

    public function testRouteCreate() {
        $response = $this->get("/products/create");
        $response->assertStatus(200);
    }

    public function testRouteShow() {
        $product = Product::create([
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);
        $id = $product->id;
        $response = $this->get(route('products.show', $id), [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);
        $response->assertStatus(200);
    }

    public function testRouteEdit() {
        $product = Product::create([
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);
        $id = $product->id;
        $response = $this->get(route('products.edit', $id), [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);
        $response->assertStatus(200);
    }

    // Routes de fonctions
    public function testRouteStore() {
        $response = $this->post(route('products.store'), [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);

        $response->assertRedirect('/products');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);
    }

    public function testRouteUpdate() {
        $product = Product::create([
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);
        $id = $product->id;
        $response = $this->put(route('products.update',$id), [
            'name' => 'New Phone',
            'description' => 'Banger de fou malade',
            'price' => 1800,
            'stock' => 50
        ], [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);

        $response->assertRedirect('/products');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'name' => 'New Phone',
            'description' => 'Banger de fou malade',
            'price' => 1800,
            'stock' => 50
        ]);
    }

    public function testRouteDelete() {
        $product = Product::create([
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);
        $id = $product->id;

        $this->assertDatabaseHas('products', [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);

        $response = $this->delete(route('products.destroy', $id), [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);

        $response->assertRedirect('/products');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('products', [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);
    }
}
