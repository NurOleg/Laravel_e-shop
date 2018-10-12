<?php

use Illuminate\Database\Seeder,
    App\Image,
    App\Good,
    Illuminate\Support\Facades\Storage;

class ImagesTableSeeder extends Seeder
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
        foreach ($data as $singleData) {
            if (in_array($singleData->cat_id, $sectionsToSkip) || $singleData->count_goods == 0) {
                continue;
            }
            foreach (self::IMG_PATHS as $size => $path) {
                Storage::disk('images')->put('goods/' . $size . '/' . $singleData->img_name, file_get_contents($path . $singleData->img_name));
                $path = Storage::disk('images')->url('/goods/' . $size . '/' . $singleData->img_name);
                $imgArr[$singleData->article][$size] = ['path' => $path, 'size' => $size];
            }
        }
        foreach ($imgArr as $article => $imageArr) {
            foreach ($imageArr as $image) {
                DB::table('images')->insert([
                    'src' => $image['path'],
                    'entity' => Good::class,
                    'size' => $image['size'],
                    'element' => $article,
                ]);
            }
        }
    }
}
