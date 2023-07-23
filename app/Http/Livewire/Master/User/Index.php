<?php

namespace App\Http\Livewire\Master\User;

use Livewire\Component;
use App\Http\Traits\Component\Pagination\PaginationTrait;
use App\Http\Traits\AuthenticationTrait;
use Auth;
class Index extends Component
{
    use AuthenticationTrait,PaginationTrait;
    public $results;
    public $pagination;
    public $user;


    public function mount(){
        $this->preparationDatas();
    }
    
    public function preparationDatas() {
        $results = $this->getDatas();
        $this->results = $results->items();
        $this->setPaginationAttribute($results);
    }
    public function getDatas() {
        $search = $this->search;
        $current_page = $this->current_page;
        $per_page = $this->per_page;
        $auth_status = $this->auth_status;

        $results = 'App\Models\User'::with('roles')->orderBy('id','DESC');

        
        $user = Auth::user();
        $this->user = Auth::user();
        $user_id = $user->id;
        if($user->can('read all user')){
            
        }else{
            if($user->can('read self user')){
                    $userArr = [];
                    if(count($user->usersubordinates) > 0){
                        $userArr = $user->usersubordinates->pluck('subordinate_id')->toArray();
                    }
                    array_push($userArr,$user->id);

                    $results = $results->where(function($p) use($userArr,$user_id){
                        $p->whereIn('id',$userArr);
                    });
                    
            }else{
                $results = $results->where(function($p) use($user_id){
                    $p->where('id',$user_id);
                });
            }
        }
        
        if($search){
            $results = $results->where(function($q) use($search){
                    $q->orWhere('name','LIKE','%'.$search.'%')
                    ->orWhere('username','LIKE','%'.$search.'%')
                    ->orWhere('email','LIKE','%'.$search.'%');
            });
        }
        $results = $results->paginate($per_page, ['*'], 'page', $current_page);

        return $results;
    }
    public function exportDatas($type) {
        dd($type);
        $search = $this->search;

        $results = 'App\Models\User'::orderBy('id','DESC');
        if($search){
            $results = $results->where('id','LIKE','%'.$search.'%')->orWhere('name','LIKE','%'.$search.'%');
        }
        $results = $results->get();
    }

    public function render()
    {
        $boolPermissionsCreate = $this->user->can('create all user');
        $navTab = [
            ['title' => 'All' , 'link' => '/user' , 'status' => '1'],
        ];
        if($boolPermissionsCreate){
            $navTab[] = ['title' => 'Create' , 'link' => '/user/create' , 'status' => '0'];
        }
        return view('livewire.master.user.index',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'User' , 'link' => ''],
            ],
            'navigationTab' => $navTab
        ]);
    }
}
