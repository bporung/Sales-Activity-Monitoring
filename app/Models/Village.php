<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    protected $table = 'villages';

    
    protected $appends = ['label','city_id','province_id'];
    public function getLabelAttribute()
    {
        return $this->district->city->province->name.",".$this->district->city->name.",".$this->district->name.",".$this->name.",".$this->zipcode;
    }
    public function getCityIdAttribute()
    {
        return $this->district->city_id;
    }
    public function getProvinceIdAttribute()
    {
        return $this->district->city->province_id;
    }

    public function district(){
        return $this->belongsTo('App\Models\District','district_id');
    }
    public function city(){
        return $this->hasOneThrough('App\Models\City','App\Models\District','city_id','district_id','id','id');
    }

    public function scopeSearching($query,$search = ''){
        $query->where(function($query) use($search){
            $query->where('name','LIKE','%'.$search.'%')->orWhere(function($query) use($search){
                $query->whereHas('district',function($query) use($search){
                    $query->where('name','LIKE','%'.$search.'%')->orWhere(function($query) use($search){
                        $query->whereHas('city',function($query) use($search){
                            $query->where('name','LIKE','%'.$search.'%')->orWhere(function($query) use($search){
                                $query->whereHas('province',function($query) use($search){
                                    $query->where('name','LIKE','%'.$search.'%');
                                });
                            });
                        });
                    });
                });
            });
        });
    }

}
