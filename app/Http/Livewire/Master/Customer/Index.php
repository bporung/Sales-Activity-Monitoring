<?php

namespace App\Http\Livewire\Master\Customer;

use Livewire\Component;
use App\Http\Traits\CustomerTrait;
use App\Http\Traits\Component\Pagination\PaginationTrait;
use App\Http\Traits\AuthenticationTrait;

class Index extends Component
{
    use AuthenticationTrait,CustomerTrait,PaginationTrait;
    public $results;
    public $pagination;


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

        $results = 'App\Models\Customer'::orderBy('id','DESC');
        
        if($search){
            $results = $results->where('id','LIKE','%'.$search.'%')->orWhere('name','LIKE','%'.$search.'%');
        }
        $results = $results->paginate($per_page, ['*'], 'page', $current_page);

        return $results;
    }
    public function exportDatas($type) {
        dd($type);
        $search = $this->search;

        $results = 'App\Models\Customer'::orderBy('id','DESC');
        if($search){
            $results = $results->where('id','LIKE','%'.$search.'%')->orWhere('name','LIKE','%'.$search.'%');
        }
        $results = $results->get();
    }

    public function render()
    {
        return view('livewire.master.customer.index',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'Customer' , 'link' => ''],
            ] , 
            'navigationTab' => [
                ['title' => 'all' , 'link' => '' , 'status' => '1'],
                ['title' => 'create' , 'link' => '/customer/create' , 'status' => '0'],
            ]
        ]);
    }
}
