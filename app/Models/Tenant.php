<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tenant extends Model
{
    protected $fillable = ['name', 'phone', 'db_name', 'db_user', 'db_password', 'code', 'api_token'];

    protected static function booted()
    {
        static::creating(function ($tenant) {
            $tenant->code = self::generateUniqueCode();
        });
    }

    private static function generateUniqueCode()
    {
        do {
            $code = 'CMP-'.strtoupper(Str::random(6));
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
