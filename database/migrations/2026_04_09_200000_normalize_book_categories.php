<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $coreCategories = [
            'Novel',
            'Komik',
            'Buku Anak',
            'Pendidikan',
            'Bisnis & Ekonomi',
            'Psikologi',
            'Sejarah',
            'Teknologi',
            'Self Development',
        ];

        foreach ($coreCategories as $name) {
            DB::table('categories')->updateOrInsert(
                ['name' => $name],
                [
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $categoryRows = DB::table('categories')->select('id', 'name')->get();
        $categoryByName = [];

        foreach ($categoryRows as $row) {
            $categoryByName[strtolower(trim((string) $row->name))] = (int) $row->id;
        }

        $mapToCore = [
            'sejarah & budaya' => 'Sejarah',
            'self improvement' => 'Self Development',
            'self-improvement' => 'Self Development',
            'teknik' => 'Teknologi',
            'technology' => 'Teknologi',
            'non buku' => 'Novel',
            'fashion' => 'Novel',
            'makanan' => 'Novel',
        ];

        foreach ($mapToCore as $oldName => $newName) {
            $oldId = $categoryByName[strtolower($oldName)] ?? null;
            $newId = $categoryByName[strtolower($newName)] ?? null;

            if (! $oldId || ! $newId || $oldId === $newId) {
                continue;
            }

            DB::table('books')
                ->where('category_id', $oldId)
                ->update(['category_id' => $newId]);
        }

        $allowedIds = [];

        foreach ($coreCategories as $name) {
            $id = $categoryByName[strtolower($name)] ?? null;
            if ($id) {
                $allowedIds[] = $id;
            }
        }

        $fallbackCategoryId = $categoryByName['novel'] ?? null;

        if ($fallbackCategoryId) {
            DB::table('books')
                ->whereNotIn('category_id', $allowedIds)
                ->update(['category_id' => $fallbackCategoryId]);
        }

        DB::table('categories')
            ->whereNotIn('id', $allowedIds)
            ->delete();
    }

    public function down(): void
    {
    }
};
