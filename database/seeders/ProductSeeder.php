<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'id' => 1,
                'name' => 'Premium Wireless Headphones',
                'price' => 199.99,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400',
                'category' => 'electronics',
                'description' => 'Experience crystal-clear audio with active noise cancellation and 30-hour battery life.',
                'seller-id' => '1',
            ],
            [
                'id' => 2,
                'name' => 'Luxury Gold Watch',
                'price' => 499.99,
                'image' => 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=400',
                'category' => 'accessories',
                'description' => 'Swiss movement, sapphire crystal glass, and water resistance up to 100m.',
                'seller-id' => '1',
            ],
            [
                'id' => 3,
                'name' => 'Wireless Mechanical Keyboard',
                'price' => 149.99,
                'image' => 'https://images.unsplash.com/photo-1595225476474-87563907a212?w=400',
                'category' => 'electronics',
                'description' => 'RGB lighting, hot-swappable switches, and dual connectivity.',
                'seller-id' => '1',
            ],
            [
                'id' => 4,
                'name' => 'Latest Smartphone',
                'price' => 899.99,
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400',
                'category' => 'electronics',
                'description' => '6.7\" OLED display, professional-grade camera system, all-day battery life.',
                'seller-id' => '1',
            ],
            [
                'id' => 5,
                'name' => 'Leather Travel Backpack',
                'price' => 129.99,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400',
                'category' => 'fashion',
                'description' => 'Genuine leather with padded laptop sleeve and multiple compartments.',
                'seller-id' => '1',
            ],
            [
                'id' => 6,
                'name' => 'Designer Sunglasses',
                'price' => 179.99,
                'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400',
                'category' => 'fashion',
                'description' => 'UV400 protection, polarized lenses, timeless design.',
                'seller-id' => '1',
            ],
            [
                'id' => 7,
                'name' => 'Performance Running Shoes',
                'price' => 139.99,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400',
                'category' => 'sports',
                'description' => 'Responsive cushioning, breathable mesh, advanced traction.',
                'seller-id' => '1',
            ],
            [
                'id' => 8,
                'name' => 'MacBook Pro Laptop',
                'price' => 1999.99,
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400',
                'category' => 'electronics',
                'description' => 'Latest processor, Retina display, all-day battery life.',
                'seller-id' => '1',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
