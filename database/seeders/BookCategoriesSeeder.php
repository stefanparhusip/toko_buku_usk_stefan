<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookCategoriesSeeder extends Seeder
{
    /**
     * Normalize categories so only book-related categories remain.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $targetNovel = Category::firstOrCreate(['name' => 'Novel']);
            $targetEducation = Category::firstOrCreate(['name' => 'Pendidikan']);
            $targetKids = Category::firstOrCreate(['name' => 'Buku Anak']);

            // Merge old "Kids" category into "Buku Anak".
            $legacyKids = Category::whereRaw('LOWER(name) = ?', ['kids'])->first();
            if ($legacyKids && $legacyKids->id !== $targetKids->id) {
                Book::where('category_id', $legacyKids->id)->update(['category_id' => $targetKids->id]);
                $legacyKids->delete();
            }

            // Remove non-book categories after moving related books.
            $legacySchoolKit = Category::whereRaw('LOWER(name) = ?', ['school kit'])->first();
            if ($legacySchoolKit) {
                Book::where('category_id', $legacySchoolKit->id)->update(['category_id' => $targetEducation->id]);
                $legacySchoolKit->delete();
            }

            $legacyBestSeller = Category::whereRaw('LOWER(name) = ?', ['best seller'])->first();
            if ($legacyBestSeller) {
                Book::where('category_id', $legacyBestSeller->id)->update(['category_id' => $targetNovel->id]);
                $legacyBestSeller->delete();
            }

            // Ensure recommended book categories are available.
            $required = [
                'Novel',
                'Komik',
                'E-Book',
                'Buku Anak',
                'Pendidikan',
                'Bisnis & Ekonomi',
                'Fantasi',
                'Psikologi',
            ];

            foreach ($required as $name) {
                Category::firstOrCreate(['name' => $name]);
            }
        });
    }
}
