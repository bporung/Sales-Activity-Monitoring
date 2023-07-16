<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function readers(){
        return $this->hasMany('App\Models\NotificationReader','notification_id');
    }
}
