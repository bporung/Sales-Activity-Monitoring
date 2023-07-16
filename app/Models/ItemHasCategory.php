<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemHasCategory extends Model
{
    use HasFactory;
    protected $table = 'itemhascategories';
    protected $guarded = [];
    
    public function category(){
        return $this->belongsTo('App\Models\ItemCategory','category_id');
    }
}
