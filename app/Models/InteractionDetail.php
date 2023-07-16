<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class InteractionDetail extends Model
{
    use HasFactory;
    protected $table = 'interactiondetails';
    protected $guarded = [];
    public $timestamps = false;


    protected $appends = ['use_unit_price','use_total_price'];

    public function getUseUnitPriceAttribute(){
        $unit_price = $this->unit_price;
        if($unit_price === 'secret'){return 'secret';}
        if($unit_price){
            $result = $unit_price;
            return 'Rp. '.number_format($result,0);
        }else{
            $result = '[Not Set]';
            return $result;
        }
    }
    public function getUseTotalPriceAttribute(){
        $qty = $this->qty;
        $unit_price = $this->unit_price;
        if($unit_price === 'secret'){return 'secret';}
        if($qty && $unit_price){
            $result = $qty * $unit_price;
            return 'Rp. '.number_format($result,0);
        }else{
            $result = '[Not Set]';
            return $result;
        }

    }
    
    public function setUnitPriceAttribute($value)
    {
        $user = Auth::user();
        $readOn = 0;
        if($user->can('read all price')){
            $readOn = 1;
        }else{
            if($user->can('read self price')){
                    $userArr = [];
                    if(count($user->usersubordinates) > 0){
                        $userArr = $user->usersubordinates->pluck('subordinate_id')->toArray();
                    }
                    array_push($userArr,$user->id);
                    $checkVal = $this->interaction()->whereIn('registered_by',$userArr)->count();

                    if($checkVal){
                        $readOn = 1;
                    }else{
                        $readOn = 0;
                    }
            }
        }


        if($readOn){
            $this->attributes['unit_price'] = $value;
        }else{
            $this->attributes['unit_price'] = 'secret';
        }
    }

    public function item(){
        return $this->belongsTo('App\Models\Item','item_id');
    }
}
