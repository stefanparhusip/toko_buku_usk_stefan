<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_book_to_cart_and_merge_quantity_for_same_book(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Novel']);
        $book = Book::create([
            'category_id' => $category->id,
            'title' => 'Buku A',
            'author' => 'Author A',
            'publisher' => 'Publisher A',
            'year' => '2024',
            'price' => 10000,
            'stock' => 5,
            'description' => 'Desc',
            'image' => 'books/a.jpg',
        ]);

        $this->actingAs($user)->post('/cart/add/' . $book->id);
        $this->actingAs($user)->post('/cart/add/' . $book->id);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'quantity' => 2,
            'total_price' => 20000,
        ]);

        $this->assertSame(1, Cart::where('user_id', $user->id)->where('book_id', $book->id)->count());
    }

    public function test_user_can_update_and_delete_cart_item(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Komik']);
        $book = Book::create([
            'category_id' => $category->id,
            'title' => 'Buku B',
            'author' => 'Author B',
            'publisher' => 'Publisher B',
            'year' => '2023',
            'price' => 20000,
            'stock' => 8,
            'description' => 'Desc',
            'image' => 'books/b.jpg',
        ]);

        $cart = Cart::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'quantity' => 1,
            'total_price' => 20000,
        ]);

        $this->actingAs($user)->patch('/cart/update/' . $cart->id, [
            'quantity' => 3,
        ])->assertRedirect('/cart');

        $this->assertDatabaseHas('carts', [
            'id' => $cart->id,
            'quantity' => 3,
            'total_price' => 60000,
        ]);

        $this->actingAs($user)->delete('/cart/delete/' . $cart->id)->assertRedirect('/cart');

        $this->assertDatabaseMissing('carts', [
            'id' => $cart->id,
        ]);
    }

    public function test_quantity_cannot_exceed_book_stock(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Teknologi']);
        $book = Book::create([
            'category_id' => $category->id,
            'title' => 'Buku C',
            'author' => 'Author C',
            'publisher' => 'Publisher C',
            'year' => '2022',
            'price' => 30000,
            'stock' => 1,
            'description' => 'Desc',
            'image' => 'books/c.jpg',
        ]);

        $this->actingAs($user)->post('/cart/add/' . $book->id);

        $this->actingAs($user)->post('/cart/add/' . $book->id)
            ->assertSessionHas('error');
    }
}
