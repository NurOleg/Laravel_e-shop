<?php

use Illuminate\Database\Seeder,
    Illuminate\Support\Facades\DB,
    Illuminate\Support\Carbon,
    App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Category::create();
        $categories = [];
        $jsonRes = file_get_contents('http://api.textiloptom.net/v1/Api/categories.json?api_key=b984f4cd549a4536524e1bb238a583be');
        $data = json_decode($jsonRes, true);
        $tree = $this->buildTree($data);
        foreach ($tree as $item) {
            Category::create($item);
        }
    }

    public function buildTree($items)
    {

        foreach ($items as $key => $item) {
            $items[$key]['parent_id'] = $item['parent'];
            $items[$key]['category_slug'] = $this->makeCode($item['name']);
            $items[$key]['synch_id'] = $item['id'];
            unset($items[$key]['parent']);
        }
        $childs = array();
        foreach ($items as &$item) $childs[$item['parent_id']][] = &$item;
        unset($item);
        foreach ($items as &$item) if (isset($childs[$item['synch_id']]))
            $item['children'] = $childs[$item['synch_id']];
        return $childs[0];
    }

    public function makeCode($s)
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
}
