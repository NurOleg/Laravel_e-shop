<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teammate extends Model
{
    protected $fillable = ['full_name', 'img_src', 'description'];
}
