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
        $jsonRes = file_get_contents('http://api.textiloptom.net/v3/Api/productsExt.json?api_key=b984f4cd549a4536524e1bb238a583be');
        $data = json_decode($jsonRes);
        $imgArr = [];
        $resTree = [];
        $sectionsToSkip = [
            128, 78, 117, 109, 185, 239, 191, 76, 8, 227, 3, 242, 11, 112
        ];
        $i = 0;
        foreach ($data as $singleData) {
            $i++;
            if (in_array($singleData->cat_id, $sectionsToSkip) || $singleData->count_goods == 0) {
                continue;
            }
//            foreach (self::IMG_PATHS as $size => $path) {
//                Storage::disk('images')->put('goods/' . $size . '/' . $singleData->img_name, file_get_contents($path . $singleData->img_name));
//                DB::table('images')->insert([
//                'src' => Storage::url('goods/' . $size . '/' . $singleData->img_name),
//                'entity' => Good::class,
//                'element' => $singleData->article,
//                'category_id' => array_search($singleData->IBLOCK_SECTION_ID, $categoriesArray),
//                'image_src' => $moveResult
//            ]);
//                $imgArr[$singleData->article][$size] = Storage::disk('images')->url('goods/' . $size . '/' . $singleData->img_name);
//            }
//            dump($imgArr);die;

            $resGoods[$singleData->article] =
                [
                  'name' => $singleData->name,
                  'api_id' => $singleData->id,
                  'brand' => $singleData->brand,
                  'textile' => $singleData->textile,
                  'filler' => $singleData->filler,
                  'category_id' => $singleData->cat_id,
//                  'sheet' => $singleData->sheet,
                  'base_color' => $singleData->base_color,
                ];
            $resSKU[$singleData->article][] =
                [
                    'duvet' => $singleData->duvet,
                    'api_id' => $singleData->id,
                    'pillowcase' => $singleData->pillowcase,
                    'sheet' => $singleData->sheet,
//                    'size' => $singleData->size,
                    'price' => $singleData->price,
                    'article' => $singleData->article,
                    'count' => $singleData->count_goods,
                ];
            echo $i;
        }

//        foreach ($imgArr as $article => $image) {
//            foreach ($image as $size => $url) {
//                DB::table('images')->insert([
//                    'src' => $url,
//                    'entity' => Good::class,
//                    'element' => $article,
//                ]);
//            }
//        }

        foreach ($resGoods as $article => $info) {
            DB::table('goods')->insert([
                'article' => $article,
                'name' => $info['name'],
                'api_id' => $info['api_id'],
                'brand' => $info['brand'],
                'textile' => (is_null($info['textile'])) ? 0 : $info['textile'],
                'category_id' => $info['category_id'],
                'base_color' => (is_null($info['base_color'])) ? 0 : $info['base_color'],
                'filler' => (is_null($info['filler'])) ? 0 : $info['filler'],
            ]);
        }

        foreach ($resSKU as $article => $infoSKUarr) {
            foreach ($infoSKUarr as $infoSKU) {
                DB::table('sku')->insert([
                    'article' => $article,
                    'duvet' => $infoSKU['duvet'],
                    'api_id' => $infoSKU['api_id'],
                    'pillowcase' => $infoSKU['pillowcase'],
                    'sheet' => $infoSKU['sheet'],
                    'price' => $infoSKU['price'],
                    'count' => $infoSKU['count'],
                ]);
            }
        }
    }

    static function translit($s)
    {
        $s = (string)$s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
        $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }

    /**
     * @param $url
     * @param $filename
     * @return bool|string
     */
    static function moveFileToServer($url, $filename, $size)
    {
        $contents = file_get_contents($url . $filename);
        $save_path = "/public/images/goods/" . $size . '/' . $filename;
        if (file_put_contents($save_path, $contents) !== false) {
            return $save_path;
        }
        return false;
    }
}
