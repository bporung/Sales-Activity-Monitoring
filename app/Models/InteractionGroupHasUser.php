<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteractionGroupHasUser extends Model
{
    use HasFactory;
    protected $table = 'interactiongroup_has_users';
    protected $primaryKey = ['interactiongroup_id', 'user_id'];
    public $incrementing = false;
    protected $guarded = [];


    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
