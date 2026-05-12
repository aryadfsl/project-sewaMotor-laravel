<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Tambah data dummy Category (4 data)
        DB::table('categories')->insert([
            [
                'category_id' => 1,
                'category_name' => 'Matic',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 2,
                'category_name' => 'Sport',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 3,
                'category_name' => 'Classic',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 4,
                'category_name' => 'Adventure',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Tambah data dummy Brand (6 data)
        DB::table('brands')->insert([
            [
                'brand_id' => 1,
                'nama_brand' => 'Honda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'brand_id' => 2,
                'nama_brand' => 'Yamaha',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'brand_id' => 3,
                'nama_brand' => 'Kawasaki',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'brand_id' => 4,
                'nama_brand' => 'Suzuki',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'brand_id' => 5,
                'nama_brand' => 'Harley Davidson',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'brand_id' => 6,
                'nama_brand' => 'Aston Martin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Tambah data dummy Product (brand_id ikut relasi)
        DB::table('products')->insert([
            [
                'product_id' => 1,
                'category_id' => 1,
                'brand_id' => 1,
                'product_name' => 'Honda Vario 150',
                'product_price' => 25000000,
                'product_stock' => 15,
                'image' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 2,
                'category_id' => 2,
                'brand_id' => 2,
                'product_name' => 'Yamaha R15',
                'product_price' => 35000000,
                'product_stock' => 8,
                'image' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'category_id' => 3,
                'brand_id' => 3,
                'product_name' => 'Kawasaki W175',
                'product_price' => 32000000,
                'product_stock' => 5,
                'image' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 4,
                'category_id' => 4,
                'brand_id' => 4,
                'product_name' => 'Suzuki V-Strom 250',
                'product_price' => 60000000,
                'product_stock' => 3,
                'image' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
