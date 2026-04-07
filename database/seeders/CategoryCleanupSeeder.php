<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryCleanupSeeder extends Seeder
{
    /**
     * Normalize categories to a clean book-focused list.
     */
    public function run(): void
    {
        $targetCategories = [
            'Novel',
            'Komik',
            'Buku Anak',
            'Pendidikan',
            'Bisnis & Ekonomi',
            'Psikologi',
            'Fantasi',
            'Self Improvement',
            'Sejarah & Budaya',
            'E-Book',
        ];

        $targetIds = collect($targetCategories)->mapWithKeys(function (string $name) {
            $category = Category::firstOrCreate(['name' => $name]);

            return [$name => $category->id];
        });

        $resolveTarget = function (string $name): string {
            $normalized = Str::lower(trim($name));

            $exactMap = [
                'novel' => 'Novel',
                'komik' => 'Komik',
                'buku anak' => 'Buku Anak',
                'pendidikan' => 'Pendidikan',
                'bisnis & ekonomi' => 'Bisnis & Ekonomi',
                'psikologi' => 'Psikologi',
                'fantasi' => 'Fantasi',
                'self improvement' => 'Self Improvement',
                'sejarah & budaya' => 'Sejarah & Budaya',
                'e-book' => 'E-Book',
                'ebook' => 'E-Book',
            ];

            if (isset($exactMap[$normalized])) {
                return $exactMap[$normalized];
            }

            if (str_contains($normalized, 'psikologi')) {
                return 'Psikologi';
            }

            if (str_contains($normalized, 'ebook') || str_contains($normalized, 'e-book')) {
                return 'E-Book';
            }

            if (str_contains($normalized, 'bisnis') || str_contains($normalized, 'ekonomi')) {
                return 'Bisnis & Ekonomi';
            }

            if (str_contains($normalized, 'anak')) {
                return 'Buku Anak';
            }

            if (str_contains($normalized, 'sejarah') || str_contains($normalized, 'budaya')) {
                return 'Sejarah & Budaya';
            }

            if (str_contains($normalized, 'komik') || str_contains($normalized, 'grafis')) {
                return 'Komik';
            }

            if (
                str_contains($normalized, 'pendidikan') ||
                str_contains($normalized, 'referensi') ||
                str_contains($normalized, 'kamus') ||
                str_contains($normalized, 'ensiklopedia')
            ) {
                return 'Pendidikan';
            }

            if (
                str_contains($normalized, 'self') ||
                str_contains($normalized, 'improvement') ||
                str_contains($normalized, 'pengembangan') ||
                str_contains($normalized, 'motivasi')
            ) {
                return 'Self Improvement';
            }

            if (str_contains($normalized, 'fantasi')) {
                return 'Fantasi';
            }

            if (str_contains($normalized, 'novel') || str_contains($normalized, 'fiksi')) {
                return 'Novel';
            }

            $nonBookKeywords = [
                'non buku',
                'school kit',
                'makanan',
                'minuman',
                'fashion',
                'aksesoris',
                'musik',
                'olahraga',
                'mainan',
                'kesehatan',
                'donasi',
            ];

            foreach ($nonBookKeywords as $keyword) {
                if (str_contains($normalized, $keyword)) {
                    return 'Pendidikan';
                }
            }

            return 'Novel';
        };

        Category::query()->orderBy('id')->get()->each(function (Category $category) use ($resolveTarget, $targetIds) {
            $targetName = $resolveTarget($category->name);
            $targetId = $targetIds[$targetName];

            if ($category->id !== $targetId) {
                Book::where('category_id', $category->id)->update(['category_id' => $targetId]);
            }
        });

        Category::whereNotIn('id', $targetIds->values()->all())->delete();
    }
}
