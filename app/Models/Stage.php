<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;
    
    protected $appends = ['label'];
    public function getLabelAttribute()
    {
        return $this->name;
    }
    public function interactions(){
        return $this->hasMany('App\Models\Interaction','stage_id');
    }
}
