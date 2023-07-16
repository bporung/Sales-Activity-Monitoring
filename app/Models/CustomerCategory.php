<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'customercategories';

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id','code')->where('group','CustomerCategory');
    }
}
