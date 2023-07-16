<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportUserPerformance extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'report_user_performances';
    protected $guarded = [];

    public function registered(){
        return $this->belongsTo('App\Models\User','registered_by');
    }
}
