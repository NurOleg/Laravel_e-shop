<?php

namespace App;

use Illuminate\Database\Eloquent\Model,
    Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    protected $table = 'categories';

}
