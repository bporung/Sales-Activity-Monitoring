<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;
    protected $table = 'itemcategories';
    protected $guarded = [];
    protected $appends = ['label'];
    public function getLabelAttribute()
    {
        return $this->name;
    }

    
    public function parent(){
        return $this->belongsTo('App\Models\ItemCategory','parent_id');
    }

}
