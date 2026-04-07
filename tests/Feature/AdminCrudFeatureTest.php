<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCrudFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_crud_category(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post('/admin/categories', ['name' => 'Komik'])
            ->assertRedirect('/admin/categories');

        $category = Category::where('name', 'Komik')->first();
        $this->assertNotNull($category);

        $this->actingAs($admin)
            ->put('/admin/categories/' . $category->id, ['name' => 'Komik Update'])
            ->assertRedirect('/admin/categories');

        $this->assertDatabaseHas('categories', ['name' => 'Komik Update']);

        $this->actingAs($admin)
            ->delete('/admin/categories/' . $category->id)
            ->assertRedirect('/admin/categories');

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_can_crud_book(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Novel']);

        $image = UploadedFile::fake()->image('book.jpg');

        $this->actingAs($admin)
            ->post('/admin/books', [
                'category_id' => $category->id,
                'title' => 'Book One',
                'author' => 'Author One',
                'publisher' => 'Publisher One',
                'year' => '2024',
                'price' => 120000,
                'stock' => 10,
                'description' => 'Description One',
                'image' => $image,
            ])
            ->assertRedirect('/admin/books');

        $book = Book::where('title', 'Book One')->first();
        $this->assertNotNull($book);
        $this->assertNotEmpty($book->image);

        $newImage = UploadedFile::fake()->image('book-new.jpg');

        $this->actingAs($admin)
            ->put('/admin/books/' . $book->id, [
                'category_id' => $category->id,
                'title' => 'Book Updated',
                'author' => 'Author One',
                'publisher' => 'Publisher One',
                'year' => '2024',
                'price' => 130000,
                'stock' => 7,
                'description' => 'Description Update',
                'image' => $newImage,
            ])
            ->assertRedirect('/admin/books');

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Book Updated',
            'price' => 130000,
            'stock' => 7,
        ]);

        $this->actingAs($admin)
            ->delete('/admin/books/' . $book->id)
            ->assertRedirect('/admin/books');

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_admin_can_access_order_monitoring_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        Order::create([
            'user_id' => $user->id,
            'order_code' => 'ORD-TEST-1001',
            'total_payment' => 100000,
            'status' => 'pending',
            'payment_method' => 'COD',
            'resi' => null,
        ]);

        $this->actingAs($admin)
            ->get('/admin/orders')
            ->assertStatus(200)
            ->assertSee('Monitoring Orders')
            ->assertSee('ORD-TEST-1001');
    }
}
