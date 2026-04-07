<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_checkout_page_when_cart_has_items(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Novel']);
        $book = Book::create([
            'category_id' => $category->id,
            'title' => 'Buku Checkout',
            'author' => 'Author',
            'publisher' => 'Publisher',
            'year' => '2024',
            'price' => 50000,
            'stock' => 10,
            'description' => 'Desc',
            'image' => 'books/a.jpg',
        ]);

        Cart::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'quantity' => 2,
            'total_price' => 100000,
        ]);

        $this->actingAs($user)
            ->get('/checkout')
            ->assertStatus(200)
            ->assertSee('Checkout')
            ->assertSee('COD');
    }

    public function test_user_can_process_checkout_and_cart_will_be_cleared(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Teknologi']);
        $book = Book::create([
            'category_id' => $category->id,
            'title' => 'Buku Proses',
            'author' => 'Author',
            'publisher' => 'Publisher',
            'year' => '2023',
            'price' => 75000,
            'stock' => 5,
            'description' => 'Desc',
            'image' => 'books/b.jpg',
        ]);

        Cart::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'quantity' => 2,
            'total_price' => 150000,
        ]);

        $response = $this->actingAs($user)
            ->post('/checkout/process', [
                'payment_method' => 'COD',
            ]);

        $response->assertStatus(200);
        $response->assertSee('Order Berhasil Dibuat');

        $order = Order::where('user_id', $user->id)->first();

        $this->assertNotNull($order);
        $this->assertSame('pending', $order->status);
        $this->assertSame('COD', $order->payment_method);
        $this->assertSame(150000, $order->total_payment);

        $this->assertDatabaseHas('order_details', [
            'order_id' => $order->id,
            'book_id' => $book->id,
            'quantity' => 2,
            'price' => 75000,
            'subtotal' => 150000,
        ]);

        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $this->assertSame(3, $book->fresh()->stock);
    }

    public function test_user_cannot_checkout_when_cart_is_empty(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/checkout/process', [
                'payment_method' => 'COD',
            ])
            ->assertRedirect('/cart')
            ->assertSessionHas('error');

        $this->assertSame(0, Order::count());
        $this->assertSame(0, OrderDetail::count());
    }
}
