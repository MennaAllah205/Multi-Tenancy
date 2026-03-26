<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public static function onBranch($branch = null)
    {
        $instance = new static;
        $instance->setConnection($branch);

        return $instance;
    }
}
