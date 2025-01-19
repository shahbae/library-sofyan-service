<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Division extends Model
{
    use HasFactory;

    protected $table = 'division';

    public $incrementing = false; // Nonaktifkan auto-increment
    protected $keyType = 'string'; // Pastikan ID berupa string

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Set UUID otomatis sebelum membuat record baru
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }
}
