<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Dress', 'Outer', 'Kebaya'] as $name) {
            \App\Models\Category::firstOrCreate(['slug' => \Illuminate\Support\Str::slug($name)], ['name' => $name]);
        }

        $dress  = \App\Models\Category::where('slug', 'dress')->first();
        $outer  = \App\Models\Category::where('slug', 'outer')->first();
        $kebaya = \App\Models\Category::where('slug', 'kebaya')->first();

        $services = [
            [$dress->id, 'Dress Pesta', 450000, 3.0],
            [$dress->id, 'Dress Harian', 300000, 2.5],
            [$outer->id, 'Outer Blazer', 380000, 2.0],
            [$kebaya->id, 'Kebaya Modern', 550000, 2.5],
        ];
        foreach ($services as [$cat, $name, $price, $meter]) {
            \App\Models\Service::firstOrCreate(['name' => $name], [
                'category_id'       => $cat,
                'price'             => $price,
                'fabric_need_meter' => $meter,
                'description'       => "Jahit custom {$name}.",
            ]);
        }

        $fabrics = [
            ['Pink', '#be3a5f'],
            ['Hijau Sage', '#7a9e6b'],
            ['Krem', '#d9b99b'],
            ['Biru', '#4a5fa0'],
            ['Hitam', '#2a1a1f'],
        ];
        foreach ($fabrics as [$color, $hex]) {
            \App\Models\Fabric::firstOrCreate(['name' => 'Satin', 'color_name' => $color], [
                'texture'         => 'Halus mengkilap',
                'color_hex'       => $hex,
                'price_per_meter' => 60000,
            ]);
        }

        foreach (['S', 'M', 'L', 'XL'] as $s) {
            \App\Models\Size::firstOrCreate(['size_name' => $s, 'customer_id' => null], [
                'dimensions_label' => "Ukuran standar {$s}",
                'measurement_unit' => 'cm',
            ]);
        }
    }
}
