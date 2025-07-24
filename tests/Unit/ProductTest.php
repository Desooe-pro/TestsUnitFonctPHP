<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use App\Models\Product;

class ProductTest extends TestCase {
    use RefreshDatabase;
    public function testAttributesProduct() {
        $product = [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150
        ];

        $products = Product::create($product);

        $this->assertInstanceOf(Product::class, $products);
        $this->assertEquals('Phone', $products->name);
        $this->assertEquals('Banger de fou', $products->description);
        $this->assertEquals(1500, $products->price);
        $this->assertEquals(150, $products->stock);
    }

    public function testUpdateProduct() {
        $product = [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150
        ];
        $productUpdate = [
            'name' => 'New Phone',
            'description' => 'Banger de fou malade',
            'price' => 1800,
            'stock' => 50
        ];

        $products = Product::create($product);

        $this->assertInstanceOf(Product::class, $products);

        $products->update($productUpdate);

        $this->assertEquals('New Phone', $products->name);
        $this->assertEquals('Banger de fou malade', $products->description);
        $this->assertEquals(1800, $products->price);
        $this->assertEquals(50, $products->stock);
    }

    public function testDeleteProduct() {
        $amount = 0;
        $product = [
            'name' => 'Phone',
            'description' => 'Banger de fou',
            'price' => 1500,
            'stock' => 150
        ];

        $products = Product::create($product);

        $id = $products->id;

        $liste = Product::all();

        foreach ($liste as $prod) {
            if ($prod->id === $id) {
                $amount += 1;
            }
            $this->assertTrue($prod->id === $id);
        }

        $this->assertTrue($amount === 1);
        $amount = 0;

        $products->delete();

        $liste = Product::all();

        foreach ($liste as $prod) {
            if ($prod->id === $id) {
                $amount += 1;
            }
            $this->assertTrue($prod->id === $id);
        }

        $this->assertTrue($amount === 0);
    }
}
