<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class FetchTheMealDbProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:themealdb-products {--query=bread : Kata kunci pencarian produk}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ambil data roti dari TheMealDB API dan simpan/update ke database lokal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = $this->option('query');
        $this->info("Mengambil data roti dari TheMealDB API (query: {$query})...");

        try {
            $response = Http::timeout(10)->get("https://www.themealdb.com/api/json/v1/1/search.php?s={$query}");

            if (!$response->successful() || empty($response->json('meals'))) {
                $this->error("Tidak ada data ditemukan untuk query: {$query}");
                return 1;
            }

            $meals = $response->json('meals');
            $count = 0;

            foreach ($meals as $meal) {
                // Kumpulkan bahan-bahan utama sebagai deskripsi jika ringkas
                $ingredients = [];
                for ($i = 1; $i <= 8; $i++) {
                    $ing = trim($meal["strIngredient{$i}"] ?? '');
                    if (!empty($ing)) {
                        $ingredients[] = $ing;
                    }
                }

                $ingredientStr = !empty($ingredients) ? 'Bahan utama: ' . implode(', ', $ingredients) : '';
                $instructions = trim(preg_replace('/\s+/', ' ', $meal['strInstructions'] ?? ''));
                $description = !empty($ingredientStr) 
                    ? $ingredientStr . '. ' . substr($instructions, 0, 150) . '...' 
                    : substr($instructions, 0, 200) . '...';

                // Tentukan harga berdasar ID meal secara konsisten (kisaran Rp 12.000 - Rp 35.000)
                $price = 12000 + (((int) $meal['idMeal'] % 24) * 1000);
                $stock = 15 + (((int) $meal['idMeal'] % 35));

                Product::updateOrCreate(
                    ['name' => $meal['strMeal']],
                    [
                        'description' => $description,
                        'price' => $price,
                        'image' => $meal['strMealThumb'],
                        'stock' => $stock,
                    ]
                );

                $count++;
            }

            $this->info("Berhasil mengimpor/memperbarui {$count} produk roti ke database!");
            return 0;
        } catch (\Exception $e) {
            $this->error("Gagal terhubung ke TheMealDB API: " . $e->getMessage());
            return 1;
        }
    }
}
