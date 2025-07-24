<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use App\Http\Controllers\ProductController;

class MessageTest extends TestCase {
    use RefreshDatabase;

    public function testRouteStore() {
        $response = $this->post(route('products.store'), [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);

        $response->assertRedirect('/products');
        $response->assertSessionHas('success');

        $response = $this->followRedirects($response);
        $response->assertSee('Produit ajouté avec succès !');

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

        $response = $this->followRedirects($response);
        $response->assertSee('Produit mis à jour avec succès !');

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

        $response = $this->followRedirects($response);
        $response->assertSee('Produit supprimé avec succès !');

        $this->assertDatabaseMissing('products', [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150,
        ]);
    }
}
