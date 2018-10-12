<?php

use Illuminate\Database\Seeder;

class UpdateGoodsTableSeeder extends Seeder
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
        $resArr = [];

        $sectionsToSkip = [
            128, 78, 117, 109, 185, 239, 191, 76, 8, 227, 3, 242, 11, 112
        ];

        foreach ($data as $datum) {
            if (in_array($datum->cat_id, $sectionsToSkip) || $datum->count_goods == 0) {
                continue;
            }
            $resArr[$datum->article] = $datum;
        }

        foreach ($resArr as $article => $item) {

            $good = App\Good::find($article);
            if(!is_null($good)) {
                $good->brand = $item->brand;
                $good->base_color = is_null($item->base_color) ? '0' : $item->base_color;
                $good->filler = is_null($item->filler) ? '0' : $item->filler;
                $good->textile = is_null($item->textile) ? '0' : $item->textile;
                $good->count_color = is_null($item->color_count) ? '0' : $item->color_count;

                $good->save();
            }
        }
    }
}
