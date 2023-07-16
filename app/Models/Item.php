<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Item extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $incrementing = false;
    protected $appends = ['label'];
    public function getLabelAttribute()
    {
        return $this->code .' - '. $this->name;
    }

    
    public function itemcategories(){
        return $this->hasMany('App\Models\ItemHasCategory','item_id');
    }
    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand_id');
    }
    public function type(){
        return $this->belongsTo('App\Models\Category','type_id','code')->where('group','ItemType');
    }

    public function registered(){
        return $this->belongsTo('App\Models\User','registered_by');
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
