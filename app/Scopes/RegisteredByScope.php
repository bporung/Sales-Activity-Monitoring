<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Auth;
class RegisteredByScope implements Scope
{
    protected $model_name;
    protected $action_name;
    protected $auth_status;

    public function __construct($model_name,$action_name)
    {
        $this->model_name = $model_name;
        $this->action_name = $action_name;
    }


    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();

        $all_action_name = $this->action_name.' all '.$this->model_name;
        if($this->action_name === 'create'){
            $all_action_name = $this->action_name.' '.$this->model_name;
        }

        $self_action_name = $this->action_name.' self '.$this->model_name;

        $auth_status = 0;
        if($user->can($all_action_name)){
            $auth_status = 1;
        }else{
            if($user->can($self_action_name)){
                if(in_array($user->id, $userArr)){
                    $auth_status = 2;
                }
            }
        };
        
        // FULL ACCESS
        if($auth_status === 1){}

        // SPECIFIC ACCESS
        if($auth_status === 2){
            $userArr = [];
            if(count($user->usersubordinates) > 0){
                $userArr = $user->usersubordinates->pluck('subordinate_id')->toArray();
            }
            array_push($userArr,$user->id);
            
            $builder->whereIn('registered_by',$userArr);
        }

        // NO ACCESS
        if($auth_status === 0){
            $builder->where('registered_by','xxxxxxxxxxxxxxxxxxx')->take(0);
        }
    }
}