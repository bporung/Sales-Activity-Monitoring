<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $incrementing = false;
    protected $appends = ['label'];
    public function getLabelAttribute()
    {
        return $this->name;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model)  {
            try {
                $model->id = Str::uuid();
            } catch (exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}
