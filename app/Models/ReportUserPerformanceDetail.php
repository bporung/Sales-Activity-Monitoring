<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportUserPerformanceDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'report_user_performance_details';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
