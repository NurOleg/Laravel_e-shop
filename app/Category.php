<?php

namespace App;

use Illuminate\Database\Eloquent\Model,
    Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    protected $table = 'categories';

    public function getOnMainItems($limit = 6)
    {
        return Category::where('main', 1)->limit($limit)->get();
    }
}
