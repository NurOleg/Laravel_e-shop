<?php

use Illuminate\Database\Seeder,
    Illuminate\Support\Facades\DB,
    Illuminate\Support\Carbon;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->delete();
        DB::table('cities')->insert([
            'title' => 'Санкт-Петербург',
            'code' => 'spb',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('cities')->insert([
            'title' => 'Москва',
            'code' => 'msk',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
