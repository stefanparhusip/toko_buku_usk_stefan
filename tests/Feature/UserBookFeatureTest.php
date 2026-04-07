<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserBookFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_book_list_page(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Novel']);

        Book::create([
            'category_id' => $category->id,
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'publisher' => 'Bentang Pustaka',
            'year' => '2005',
            'price' => 95000,
            'stock' => 20,
            'description' => 'Novel inspiratif.',
            'image' => 'books/sample.jpg',
        ]);

        $response = $this->actingAs($user)->get('/books');

        $response->assertStatus(200);
        $response->assertSee('Laskar Pelangi');
    }

    public function test_authenticated_user_can_view_book_detail_page(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Komik']);

        $book = Book::create([
            'category_id' => $category->id,
            'title' => 'One Piece',
            'author' => 'Eiichiro Oda',
            'publisher' => 'Shueisha',
            'year' => '1997',
            'price' => 50000,
            'stock' => 15,
            'description' => 'Petualangan bajak laut.',
            'image' => 'books/onepiece.jpg',
        ]);

        $response = $this->actingAs($user)->get('/books/' . $book->id);

        $response->assertStatus(200);
        $response->assertSee('One Piece');
        $response->assertSee('Eiichiro Oda');
    }

    public function test_book_search_works_by_title_and_category(): void
    {
        $user = User::factory()->create();

        $techCategory = Category::create(['name' => 'Teknologi']);
        $historyCategory = Category::create(['name' => 'Sejarah']);

        Book::create([
            'category_id' => $techCategory->id,
            'title' => 'Laravel Mastery',
            'author' => 'John Doe',
            'publisher' => 'Tech Press',
            'year' => '2024',
            'price' => 150000,
            'stock' => 8,
            'description' => 'Panduan Laravel lengkap.',
            'image' => 'books/laravel.jpg',
        ]);

        Book::create([
            'category_id' => $historyCategory->id,
            'title' => 'Dunia Kuno',
            'author' => 'Jane Doe',
            'publisher' => 'History Press',
            'year' => '2020',
            'price' => 120000,
            'stock' => 5,
            'description' => 'Sejarah peradaban kuno.',
            'image' => 'books/history.jpg',
        ]);

        $responseByTitle = $this->actingAs($user)->get('/books?search=Laravel');
        $responseByTitle->assertStatus(200);
        $responseByTitle->assertSee('Laravel Mastery');
        $responseByTitle->assertDontSee('Dunia Kuno');

        $responseByCategory = $this->actingAs($user)->get('/books?search=Sejarah');
        $responseByCategory->assertStatus(200);
        $responseByCategory->assertSee('Dunia Kuno');
        $responseByCategory->assertDontSee('Laravel Mastery');
    }
}
