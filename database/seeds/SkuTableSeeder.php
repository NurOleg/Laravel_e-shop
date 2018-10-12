<?php

use Illuminate\Database\Seeder;

class SkuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonRes = file_get_contents('http://api.textiloptom.net/v3/Api/productsVal.json?api_key=b984f4cd549a4536524e1bb238a583be');
        $data = json_decode($jsonRes);
        $sectionsToSkip = [
            128, 78, 117, 109, 185, 239, 191, 76, 8, 227, 3, 242, 11, 112
        ];
        $i = 0;
        foreach ($data as $singleData) {
            $i++;
            if (in_array($singleData->cat_id, $sectionsToSkip)) {
                continue;
            }
            $sku = App\Sku::where('article', $singleData->article)->where('price', $singleData->price)->first();
            if(!is_null($sku)) {
                $sku->size = $singleData->param_value;
                $sku->save();
            }
        }
    }
}
