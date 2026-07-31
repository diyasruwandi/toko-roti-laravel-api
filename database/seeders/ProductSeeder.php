<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // CROISSANT
            [
                'name' => 'Butter Croissant Premium',
                'description' => 'Croissant mentega klasik khas Prancis dengan lapisan renyah di luar dan lembut berlapis di dalam.',
                'price' => 22000,
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600',
                'stock' => 30,
            ],
            [
                'name' => 'Almond Croissant',
                'description' => 'Croissant lezat dengan isian krim almond manis dan taburan kacang almond panggang di atasnya.',
                'price' => 28000,
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600',
                'stock' => 25,
            ],
            [
                'name' => 'Chocolate Lava Croissant',
                'description' => 'Croissant renyah dengan lelehan cokelat Belgian hangat di tengahnya yang meleleh di mulut.',
                'price' => 26000,
                'image' => 'https://images.unsplash.com/photo-1623334044303-241021148842?w=600',
                'stock' => 20,
            ],
            [
                'name' => 'Matcha Cream Croissant',
                'description' => 'Croissant dengan isian matcha krim hijau khas Uji Jepang yang wangi dan lezat.',
                'price' => 27000,
                'image' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?w=600',
                'stock' => 18,
            ],

            // PASTRY
            [
                'name' => 'Pain au Chocolat',
                'description' => 'Pastry berlapis-lapis khas Prancis berisi dua batang cokelat hitam berkualitas tinggi.',
                'price' => 25000,
                'image' => 'https://images.unsplash.com/photo-1608198093002-ad4e005484ec?w=600',
                'stock' => 35,
            ],
            [
                'name' => 'Cinnamon Roll Pastry',
                'description' => 'Gulungan pastry manis aroma kayu manis hangat dipadu dengan glaze gula cair di atasnya.',
                'price' => 23000,
                'image' => 'https://images.unsplash.com/photo-1509365465985-25d11c17e812?w=600',
                'stock' => 40,
            ],
            [
                'name' => 'Apple Danish Pastry',
                'description' => 'Pastry Danish renyah dengan topping apel karamel manis beraroma kayu manis.',
                'price' => 24000,
                'image' => 'https://images.unsplash.com/photo-1541167760496-1628856ab772?w=600',
                'stock' => 22,
            ],
            [
                'name' => 'Strawberry Cheese Tart Pastry',
                'description' => 'Pastry tart renyah diisi krim keju lembut dan stroberi segar di atasnya.',
                'price' => 29000,
                'image' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=600',
                'stock' => 15,
            ],

            // DONAT
            [
                'name' => 'Glazed Classic Donut',
                'description' => 'Donat kentang super lembut dengan balutan gula glaze klasik yang mengkilap dan manis pas.',
                'price' => 12000,
                'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=600',
                'stock' => 50,
            ],
            [
                'name' => 'Boston Cream Donut',
                'description' => 'Donat lembut diisi custard vanila halus dan dilapisi cokelat leleh di permukaan.',
                'price' => 18000,
                'image' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?w=600',
                'stock' => 30,
            ],

            // ROTI (BREAD)
            [
                'name' => 'Sourdough Country Loaf',
                'description' => 'Roti gandum fermentasi ragi alami dengan kulit renyah keras dan tekstur dalam yang kenyal lezat.',
                'price' => 38000,
                'image' => 'https://images.unsplash.com/photo-1589367920969-ab8e050bbb04?w=600',
                'stock' => 20,
            ],
            [
                'name' => 'Brioche Soft Loaf',
                'description' => 'Roti tawar manis kaya mentega dan telur, sangat lembut dan cocok untuk sarapan.',
                'price' => 26000,
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600',
                'stock' => 25,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
