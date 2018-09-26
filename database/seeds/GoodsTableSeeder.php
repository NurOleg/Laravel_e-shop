<?php

use Illuminate\Database\Seeder,
    App\Category,
    App\Image;

class GoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all()
            ->get(['id', 'code']);
        $categoriesArray = [];
        foreach ($categories as $category) {
            $categoriesArray[$category->id] = $category->code;
        }
//        $jsonRes = file_get_contents('http://pparket.ru/goodsapi.php');
        $jsonRes = [];
        $data = json_decode($jsonRes);
        foreach ($data as $singleData) {

            $moveResult = self::moveFileToServer($singleData->DETAIL_PICTURE['URL'], 'img.jpg');
            if ($moveResult !== false) {
                $image = new Image;

                $image->alt = $singleData->NAME . ' alt';
                $image->title = $singleData->NAME . ' title';
                $image->src = $moveResult;

                $image->save();
            }

            DB::table('goods')->insert([
                'name' => $singleData->NAME,
                'code' => self::translit($singleData->NAME),
                'price' => (int)$singleData->PROPERTY_PRICE_VALUE,
                'category_id' => array_search($singleData->IBLOCK_SECTION_ID, $categoriesArray),
                'image_src' => $moveResult
            ]);
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
    static function moveFileToServer($url, $filename)
    {
        $contents = file_get_contents($url);
        $save_path = "/public/images/goods/" . $filename;
        if (file_put_contents($save_path, $contents) !== false) {
            return $save_path;
        }
        return false;
    }
}
