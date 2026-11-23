<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use App\Models\Fabric;
use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        $categoryNames = [
            'Dress',
            'Dress Formal',
            'Kebaya',
            'Busana Muslimah',
            'Outer',
            'Setelan Wanita',
        ];

        $categories = [];

        foreach ($categoryNames as $name) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );

            $categories[$name] = $category->id;
        }

        /*
        |--------------------------------------------------------------------------
        | FOTO FASHION ASLI
        |--------------------------------------------------------------------------
        | Sumber: Unsplash dan Pexels.
        | URL foto disimpan langsung agar bisa digunakan pada galeri.
        */

        $photos = [
            'dress1' => 'https://images.unsplash.com/photo-1746025241442-64f9ad664905?auto=format&fit=crop&w=1200&q=85',
            'dress2' => 'https://images.pexels.com/photos/35649468/pexels-photo-35649468.jpeg',
            'dress3' => 'https://images.pexels.com/photos/9563065/pexels-photo-9563065.jpeg',

            'formal1' => 'https://images.pexels.com/photos/35649461/pexels-photo-35649461.jpeg',
            'formal2' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=1200&q=85',
            'formal3' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1200&q=85',

            'daily1' => 'https://images.unsplash.com/photo-1762154057377-cc9d3dd6900c?auto=format&fit=crop&w=1200&q=85',
            'daily2' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1200&q=85',
            'daily3' => 'https://images.unsplash.com/photo-1551232864-3f0890e580d9?auto=format&fit=crop&w=1200&q=85',

            'blazer1' => 'https://images.unsplash.com/photo-1747814965209-2301e535f209?auto=format&fit=crop&w=1200&q=85',
            'blazer2' => 'https://images.pexels.com/photos/6402850/pexels-photo-6402850.jpeg',
            'blazer3' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=1200&q=85',

            'kebaya1' => 'https://images.pexels.com/photos/40670313/pexels-photo-40670313.jpeg',
            'kebaya2' => 'https://unsplash.com/photos/wogd1mhVuFM/download?force=true',
            'kebaya3' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=1200&q=85',

            'modest1' => 'https://images.pexels.com/photos/40966541/pexels-photo-40966541.jpeg',
            'modest2' => 'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?auto=format&fit=crop&w=1200&q=85',
            'modest3' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=1200&q=85',

            'set1' => 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1200&q=85',
            'set2' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=1200&q=85',
            'set3' => 'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?auto=format&fit=crop&w=1200&q=85',
        ];

        /*
        |--------------------------------------------------------------------------
        | 20 PRODUK KATALOG
        |--------------------------------------------------------------------------
        */

        $products = [

            [
                'name' => 'Dress Pesta',
                'category' => 'Dress',
                'price' => 450000,
                'meter' => 3.0,
                'description' => 'Dress pesta elegan dengan potongan feminin untuk acara istimewa.',
                'images' => [$photos['dress1'], $photos['dress2'], $photos['dress3']],
                'colors' => ['Hitam', 'Champagne', 'Maroon', 'Emerald'],
            ],

            [
                'name' => 'Dress Harian',
                'category' => 'Dress',
                'price' => 300000,
                'meter' => 2.5,
                'description' => 'Dress harian dengan desain nyaman dan anggun untuk berbagai aktivitas.',
                'images' => [$photos['daily1'], $photos['daily2'], $photos['daily3']],
                'colors' => ['Cream', 'Sage', 'Navy'],
            ],

            [
                'name' => 'Outer Blazer',
                'category' => 'Outer',
                'price' => 380000,
                'meter' => 2.0,
                'description' => 'Outer blazer modern dengan siluet rapi dan tampilan profesional.',
                'images' => [$photos['blazer1'], $photos['blazer2'], $photos['blazer3']],
                'colors' => ['Beige', 'Hitam', 'Mocha'],
            ],

            [
                'name' => 'Kebaya Modern',
                'category' => 'Kebaya',
                'price' => 550000,
                'meter' => 2.5,
                'description' => 'Kebaya modern dengan sentuhan tradisional yang anggun.',
                'images' => [$photos['kebaya1'], $photos['kebaya2'], $photos['kebaya3']],
                'colors' => ['Gold', 'Ivory', 'Hitam'],
            ],

            [
                'name' => 'Evening Gown',
                'category' => 'Dress Formal',
                'price' => 850000,
                'meter' => 4.0,
                'description' => 'Gaun malam berpotongan anggun untuk pesta dan acara formal.',
                'images' => [$photos['formal1'], $photos['formal2'], $photos['formal3']],
                'colors' => ['Black', 'Champagne', 'Burgundy'],
            ],

            [
                'name' => 'Maxi Dress Elegance',
                'category' => 'Dress Formal',
                'price' => 625000,
                'meter' => 3.5,
                'description' => 'Maxi dress dengan siluet panjang yang elegan dan timeless.',
                'images' => [$photos['dress2'], $photos['formal2'], $photos['dress3']],
                'colors' => ['Mocha', 'Navy', 'Ivory'],
            ],

            [
                'name' => 'Dress Satin Premium',
                'category' => 'Dress Formal',
                'price' => 725000,
                'meter' => 3.5,
                'description' => 'Dress satin dengan tampilan mewah dan jatuh kain yang anggun.',
                'images' => [$photos['dress1'], $photos['formal1'], $photos['formal3']],
                'colors' => ['Champagne', 'Emerald', 'Black'],
            ],

            [
                'name' => 'Dress A-Line',
                'category' => 'Dress',
                'price' => 425000,
                'meter' => 3.0,
                'description' => 'Dress A-line dengan potongan klasik yang cocok untuk berbagai kesempatan.',
                'images' => [$photos['daily2'], $photos['dress2'], $photos['daily3']],
                'colors' => ['Cream', 'Dusty Blue', 'Black'],
            ],

            [
                'name' => 'Dress Brokat',
                'category' => 'Dress Formal',
                'price' => 675000,
                'meter' => 3.5,
                'description' => 'Dress formal dengan inspirasi detail brokat yang feminin.',
                'images' => [$photos['dress3'], $photos['formal1'], $photos['dress1']],
                'colors' => ['Gold', 'Silver', 'Maroon'],
            ],

            [
                'name' => 'Kebaya Brokat',
                'category' => 'Kebaya',
                'price' => 650000,
                'meter' => 2.5,
                'description' => 'Kebaya brokat untuk acara keluarga, pesta, dan perayaan.',
                'images' => [$photos['kebaya1'], $photos['kebaya3'], $photos['kebaya2']],
                'colors' => ['Ivory', 'Gold', 'Dusty Pink'],
            ],

            [
                'name' => 'Kebaya Peplum',
                'category' => 'Kebaya',
                'price' => 600000,
                'meter' => 2.5,
                'description' => 'Kebaya peplum dengan bentuk pinggang yang tegas dan elegan.',
                'images' => [$photos['kebaya3'], $photos['kebaya1'], $photos['formal2']],
                'colors' => ['Navy', 'Ivory', 'Emerald'],
            ],

            [
                'name' => 'Gamis Premium',
                'category' => 'Busana Muslimah',
                'price' => 475000,
                'meter' => 3.5,
                'description' => 'Gamis panjang dengan desain modest dan tampilan premium.',
                'images' => [$photos['modest1'], $photos['modest2'], $photos['modest3']],
                'colors' => ['Mocha', 'Sage', 'Black'],
            ],

            [
                'name' => 'Gamis A-Line',
                'category' => 'Busana Muslimah',
                'price' => 425000,
                'meter' => 3.5,
                'description' => 'Gamis A-line yang nyaman dengan siluet longgar dan anggun.',
                'images' => [$photos['modest2'], $photos['modest1'], $photos['daily2']],
                'colors' => ['Cream', 'Olive', 'Navy'],
            ],

            [
                'name' => 'Tunik Elegan',
                'category' => 'Busana Muslimah',
                'price' => 325000,
                'meter' => 2.0,
                'description' => 'Tunik modern yang mudah dipadukan dengan berbagai bawahan.',
                'images' => [$photos['modest3'], $photos['daily1'], $photos['modest2']],
                'colors' => ['Beige', 'Sage', 'Black'],
            ],

            [
                'name' => 'Tunik Brokat',
                'category' => 'Busana Muslimah',
                'price' => 395000,
                'meter' => 2.5,
                'description' => 'Tunik dengan inspirasi detail brokat untuk tampilan formal.',
                'images' => [$photos['modest1'], $photos['kebaya3'], $photos['modest3']],
                'colors' => ['Ivory', 'Mocha', 'Navy'],
            ],

            [
                'name' => 'Long Outer Premium',
                'category' => 'Outer',
                'price' => 350000,
                'meter' => 2.5,
                'description' => 'Long outer dengan desain minimalis dan mudah dipadukan.',
                'images' => [$photos['blazer2'], $photos['blazer1'], $photos['blazer3']],
                'colors' => ['Cream', 'Mocha', 'Black'],
            ],

            [
                'name' => 'Blazer Classic',
                'category' => 'Outer',
                'price' => 425000,
                'meter' => 2.5,
                'description' => 'Blazer klasik untuk tampilan profesional dan modern.',
                'images' => [$photos['blazer1'], $photos['blazer3'], $photos['blazer2']],
                'colors' => ['Black', 'Beige', 'Navy'],
            ],

            [
                'name' => 'Setelan Formal',
                'category' => 'Setelan Wanita',
                'price' => 575000,
                'meter' => 3.5,
                'description' => 'Setelan wanita dengan tampilan serasi untuk acara formal.',
                'images' => [$photos['set1'], $photos['formal2'], $photos['blazer2']],
                'colors' => ['Mocha', 'Black', 'Cream'],
            ],

            [
                'name' => 'Setelan Modest',
                'category' => 'Setelan Wanita',
                'price' => 525000,
                'meter' => 3.5,
                'description' => 'Setelan modest modern dengan potongan rapi dan nyaman.',
                'images' => [$photos['modest1'], $photos['set2'], $photos['modest2']],
                'colors' => ['Sage', 'Beige', 'Navy'],
            ],

            [
                'name' => 'Setelan Blazer Wanita',
                'category' => 'Setelan Wanita',
                'price' => 625000,
                'meter' => 3.5,
                'description' => 'Setelan blazer wanita untuk tampilan formal yang elegan.',
                'images' => [$photos['set3'], $photos['blazer1'], $photos['set1']],
                'colors' => ['Black', 'Mocha', 'Ivory'],
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PRODUK
        |--------------------------------------------------------------------------
        */

        foreach ($products as $product) {
            $categoryId = $categories[$product['category']];

            Service::updateOrCreate(
                ['name' => $product['name']],
                [
                    'category_id' => $categoryId,
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'fabric_need_meter' => $product['meter'],

                    // Foto pertama menjadi foto utama.
                    'image_path' => $product['images'][0],

                    // Semua foto disimpan sebagai galeri.
                    'gallery_images' => $product['images'],

                    'available_colors' => $product['colors'],

                    'standard_sizes' => [
                        'S', 'M', 'L', 'XL', 'XXL'
                    ],

                    'allow_custom_size' => true,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BAHAN
        |--------------------------------------------------------------------------
        */

        $fabrics = [
            ['Pink', '#be3a5f'],
            ['Hijau Sage', '#7a9e6b'],
            ['Krem', '#d9b99b'],
            ['Biru', '#4a5fa0'],
            ['Hitam', '#2a1a1f'],
        ];

        foreach ($fabrics as [$color, $hex]) {
            Fabric::firstOrCreate(
                [
                    'name' => 'Satin',
                    'color_name' => $color,
                ],
                [
                    'texture' => 'Halus mengkilap',
                    'color_hex' => $hex,
                    'price_per_meter' => 60000,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | UKURAN STANDAR LAMA
        |--------------------------------------------------------------------------
        */

        foreach (['S', 'M', 'L', 'XL', 'XXL'] as $size) {
            Size::firstOrCreate(
                [
                    'size_name' => $size,
                    'customer_id' => null,
                ],
                [
                    'dimensions_label' => "Ukuran standar {$size}",
                    'measurement_unit' => 'cm',
                ]
            );
        }
    }
}
