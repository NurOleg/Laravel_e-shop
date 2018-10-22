<?php

use Illuminate\Database\Seeder,
    Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert([
            'name' => 'Наличными при получении',
            'description' => 'Описание способа оплаты наличными при получении',
        ]);
        DB::table('payments')->insert([
            'name' => 'Онлайн оплата на сайте',
            'description' => 'Описание способа оплаты онлайн оплата на сайте',
        ]);
    }
}
