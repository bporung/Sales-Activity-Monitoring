<?php

namespace App\Http\Livewire\Map\Interaction;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Http\Traits\Component\Pagination\PaginationTrait;

class Index extends Component
{
    use PaginationTrait;
    public $results;
    public $customers = [];
    public $pagination;
    public $subtitle = '';
    public $q = '';

    
    public function mount(){
        $q = \Request::get('q');
        $this->q = $q;
        $this->preparationDatas();
    }
    
    public function preparationDatas() {
        $results = $this->getDatas();
        $this->results = $results;
        $this->customers = $results->unique('customer')->pluck('customer.defaultaddress')->toArray();
        $this->dispatchBrowserEvent('contentChanged');

    }
    public function getDatas() {
        $created_date = $this->created_date;
        $search = $this->search;
        $users = $this->advSearch && isset($this->advSearch['selectedUsers']) ? $this->advSearch['selectedUsers'] : [];

        $q = $this->q;
        
        $results = 'App\Models\Interaction'::orderBy('created_at', 'DESC');
        
        if($q){
            if($q == 'all'){
                $results = $results;
                $this->subtitle = 'All';
            }
        }

        if($users && count($users) > 0){
            $results = $results->where(function($query) use($users){
                $query->whereIn('registered_by',$users);
            });
        }
        if($created_date){
            if($created_date['start'] && $created_date['end']){
                $results = $results->whereDate('created_at','>=',$created_date['start'])->whereDate('created_at','<=',$created_date['end']);
            }
        }

        if($search && $search != ''){
            $results = $results->where(function($p) use($search){
                $p->where('description','LIKE','%'.$search.'%')
                ->orWhereHas('details',function($x) use($search){
                    $x->whereHas('item',function($y) use($search){
                        $y->where('name','LIKE','%'.$search.'%')->orWhere('code','LIKE','%'.$search.'%');
                    });
                });
            });
        }

        $results = $results->get();

        return $results;
    }

    public function render()
    {
        return view('livewire.map.interaction.index',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'Map' , 'link' => ''],
                ['title' => 'Interaction : '.$this->subtitle , 'link' => ''],
            ],
        'navigationTab' => [
            ['title' => 'All' , 'link' => '/map/interaction?q=all' , 'status' =>  $this->q === 'all'],
        ]
        ]);
    }
}
