<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubordinate extends Model
{
    use HasFactory;
    protected $table = 'usersubordinates';
    protected $guarded = [];

    public function subordinate(){
        return $this->belongsTo('App\Models\User','subordinate_id');
    }
}
