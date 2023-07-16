<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Auth;
class InteractionGroup extends Model
{
    use HasFactory;
    protected $table = 'interactiongroups';
    public $incrementing = false;
    protected $guarded = [];
    protected $appends = ['label','permission_access'];
    public function getLabelAttribute()
    {
        return $this->name;
    }
    public function getPermissionAccessAttribute()
    {
        $user = Auth::user();
        if($user){
            if($user->hasRole('Super Admin') || $user->can('read all interactiongroup') || ($user->can('read self interactiongroup') && $this->users && $this->users()->where('user_id',$user->id)->count())){
                return '1';
            }else{
                return '0';
            }
        }
        return '0';
    }
    public function interactions()
    {
        return $this->hasMany('App\Models\Interaction','group_id');
    }
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer','customer_id');
    }
    public function last_interaction()
    {
        return $this->hasOne('App\Models\Interaction','group_id')->whereNotNull('finalized_at')->orderBy('created_at','DESC');
    }
    public function users()
    {
        return $this->hasManyThrough(
            'App\Models\User',
            'App\Models\InteractionGroupHasUser',
            'interactiongroup_id', 
            'id', 
            'id', 
            'user_id' 
        );
    }
    public function hasusers()
    {
        return $this->hasMany('App\Models\InteractionGroupHasUser','interactiongroup_id');
    }
    public function registered(){
        return $this->belongsTo('App\Models\User','registered_by');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model)  {
            try {
                $model->id = Str::uuid();
            } catch (exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    
    protected static function booted()
    {
        static::addGlobalScope('useraccess', function (Builder $builder) {
            $user = Auth::user();
            if($user->can('read all interactiongroup')){

            }else{
                if($user->can('read self interactiongroup')){
                        $userArr = [];
                        if(count($user->usersubordinates) > 0){
                            $userArr = $user->usersubordinates->pluck('subordinate_id')->toArray();
                        }
                        array_push($userArr,$user->id);

                        $builder->where(function($p) use($userArr){
                            $p->orWhereHas('users',function($q) use($userArr){
                                $q->whereIn('id',$userArr);
                            })->orWhereHas('interactions',function($r) use($userArr){
                                $r->whereIn('registered_by',$userArr);
                            })
                            ;
                        });
                }else{
                    $builder->where('id','#$%^&');
                }
            }
        });
    }

}
