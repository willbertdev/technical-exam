<?php

namespace Database\Seeders;

use App\Models\Product as ModelsProduct;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class Product extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        ModelsProduct::insert([
            [
                'name' => 'Product 1',
                'available_stock' => 10,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Product 2',
                'available_stock' => 20,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Product 3',
                'available_stock' => 30,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
