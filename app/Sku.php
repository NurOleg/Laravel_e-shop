<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    protected $table = 'sku';

    public function good()
    {
        return $this->belongsTo(Good::class);
    }
}
