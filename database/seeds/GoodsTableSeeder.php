<?php

use Illuminate\Database\Seeder,
    App\Category,
    App\Image,
    App\Good,
    Illuminate\Support\Facades\Storage;

class GoodsTableSeeder extends Seeder
{
    const IMG_PATHS = [
        'little' => 'http://api.textiloptom.net/exchange_data/img/small/',
        'big' => 'http://api.textiloptom.net/exchange_data/img/large/'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionsToSkip = [
            128, 78, 117, 109, 185, 239, 191, 76, 8, 227, 3, 242, 11, 112
        ];
        $arr = [];
        $skip = [];
        $jsonRes = file_get_contents('http://api.textiloptom.net/v3/Api/productsVal.json?api_key=b984f4cd549a4536524e1bb238a583be');
        $data = json_decode($jsonRes);

        $catsJson = file_get_contents('http://api.textiloptom.net/v1/Api/categories.json?api_key=b984f4cd549a4536524e1bb238a583be');
        $cats = json_decode($catsJson);

        foreach ($cats as $cat) {
            $arr[$cat->name] = $cat->id;
            if (in_array($cat->id, $sectionsToSkip)) {
                $skip[] = $cat->name;
            }
        }
        $i = 0;
        foreach ($data as $singleData) {
            $i++;

            if (in_array($singleData->cat_id, $skip) || $singleData->count_goods == 0 || $singleData->price == 0) {
                continue;
            }

            $resGoods[$singleData->article] =
                [
                    'name' => $singleData->name,
                    'api_id' => $singleData->id,
                    'brand' => $singleData->brand,
                    'textile' => $singleData->textile,
                    'base_color' => $singleData->base_color,
                    'filler' => $singleData->filler,
                    'count_color' => $singleData->color_count,
                    'category_id' => (int)$arr[$singleData->cat_id],
                ];


            $resSKU[$singleData->article][] =
                [
                    'duvet' => $singleData->duvet,
                    'api_id' => $singleData->id,
                    'pillowcase' => $singleData->pillowcase,
                    'sheet' => $singleData->sheet,
                    'price' => $singleData->price,
                    'count' => $singleData->count_goods,
                    'size' => $singleData->param_value,
                ];
        }


        foreach ($resGoods as $article => $info) {
            DB::table('goods')->insert([
                'article' => $article,
                'name' => $info['name'],
                'api_id' => $info['api_id'],
                'brand' => $info['brand'],
                'textile' => (is_null($info['textile'])) ? 0 : $info['textile'],
                'category_id' => $info['category_id'],
                'count_color' => (is_null($info['count_color'])) ? 0 : $info['count_color'],
                'base_color' => (is_null($info['base_color'])) ? 0 : $info['base_color'],
                'filler' => (is_null($info['filler'])) ? 0 : $info['filler'],
            ]);
        }

        foreach ($resSKU as $article => $infoSKUarr) {
            foreach ($infoSKUarr as $infoSKU) {
                DB::table('sku')->insert([
                    'article' => $article,
                    'duvet' => !is_null($infoSKU['duvet']) ? self::deleteDifferences($infoSKU['duvet']) : $infoSKU['duvet'],
                    'api_id' => $infoSKU['api_id'],
                    'pillowcase' => !is_null($infoSKU['duvet']) ? self::deleteDifferences($infoSKU['pillowcase']) : $infoSKU['pillowcase'],
                    'sheet' => !is_null($infoSKU['sheet']) ? self::deleteDifferences($infoSKU['sheet']) : $infoSKU['sheet'],
                    'price' => $infoSKU['price'],
                    'count' => $infoSKU['count'],
                    'size' => !is_null($infoSKU['size']) ? self::deleteDifferences($infoSKU['size']) : $infoSKU['size'],
                ]);
            }
        }
    }

    static function deleteDifferences(string $value)
    {
        $minusDot = str_replace('.', '', $value);
        // rus to lat
        $rTl = str_replace('х', 'x', $minusDot);
        $st = str_replace('2шт', '2 шт', $rTl);
        $z = str_replace(' ,', ', ', $st);
        $val = str_replace(' - ', '-', $z);

        return trim($val);
    }
}
