<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Auth;

class Interaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['label','total_price'];
    public function getLabelAttribute()
    {
        return $this->description;
    }
    public function getTotalPriceAttribute()
    {
        $qty = 0;
        $price = 0;
        $total_price_unit = 0;
        $total_price = 0;
        if($this->details->count() > 0){
            $qty = 0;
            $price = 0;
            $total_price_unit = 0;
            foreach($this->details as $detail){
                $qty = $detail->qty;
                $price = $detail->unit_price;
                $total_price_unit = $qty * $price;
                $total_price += $total_price_unit;
            }
        }
        return $total_price;
    }

    public function details(){
        return $this->hasMany('App\Models\InteractionDetail','interaction_id');
    }
    public function images(){
        return $this->hasMany('App\Models\InteractionImage','interaction_id');
    }

    public function registered(){
        return $this->belongsTo('App\Models\User','registered_by');
    }
    public function finalized(){
        return $this->belongsTo('App\Models\User','finalized_by');
    }
    public function group(){
        return $this->belongsTo('App\Models\InteractionGroup','group_id','id');
    }
    public function grouphasusers()
    {
        return $this->hasManyThrough(
            'App\Models\InteractionGroupHasUser',
            'App\Models\InteractionGroup',

            'id', 
            'interactiongroup_id', 
            
            'group_id', 
            'id' 
        );
    }
    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id');
    }
    public function stage(){
        return $this->belongsTo('App\Models\Stage','stage_id');
    }
    public function type(){
        return $this->belongsTo('App\Models\Category','type_id','code')->where('group','InteractionType');
    }

    protected static function booted()
    {
        static::addGlobalScope('useraccess', function (Builder $builder) {
            $user = Auth::user();
            $user_id = $user->id;
            if($user->can('read all interaction')){
                
            }else{
                if($user->can('read self interaction')){
                        $userArr = [];
                        if(count($user->usersubordinates) > 0){
                            $userArr = $user->usersubordinates->pluck('subordinate_id')->toArray();
                        }
                        array_push($userArr,$user->id);

                        $builder->where(function($p) use($userArr,$user_id){
                            $p->whereIn('registered_by',$userArr)
                                ->orWhereHas('grouphasusers',function($y) use($user_id){
                                    $y->whereHas('user',function($x) use($user_id){
                                        $x->where('id',$user_id);
                                    });
                            });
                        });
                        
                }else{
                    $builder->where('id','#$%^&');
                }
            }
        });
    }
}
