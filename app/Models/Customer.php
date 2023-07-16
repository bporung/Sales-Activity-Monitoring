<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $incrementing = false;
    protected $appends = ['label','full_name','categories'];
    public function getCategoriesAttribute()
    {
        $categories = 'App\Models\Category'::where('group','CustomerCategory')->whereIn('code',$this->customercategories->pluck('category_id'))->get();
        return $categories;
    }
    public function getLabelAttribute()
    {
        return $this->title->name .' '. $this->name;
    }
    public function getFullNameAttribute()
    {
        return $this->title->name .' '. $this->name;
    }
    public function province(){
        return $this->belongsTo('App\Models\Province','province_id');
    }
    public function city(){
        return $this->belongsTo('App\Models\City','city_id');
    }
    public function district(){
        return $this->belongsTo('App\Models\District','district_id');
    }
    public function village(){
        return $this->belongsTo('App\Models\Village','village_id');
    }


    public function title(){
        return $this->belongsTo('App\Models\Category','title_id','code')->where('group','CustomerTitle');
    }

    public function customercategories(){
        return $this->hasMany('App\Models\CustomerCategory','customer_id');
    }
    public function interactiongroups(){
        return $this->hasMany('App\Models\InteractionGroup','customer_id');
    }

}
