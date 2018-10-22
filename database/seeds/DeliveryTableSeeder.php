<?php

use Illuminate\Database\Seeder,
    Illuminate\Support\Facades\DB;

class DeliveryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('delivery')->insert([
            'name' => 'Почта России',
            'description' => 'Описание способа доставки Почта России',
            'cost' => 300,
        ]);
        DB::table('delivery')->insert([
            'name' => 'Курьером',
            'description' => 'Описание способа доставки Курьером',
            'cost' => 350,
        ]);
    }
}
