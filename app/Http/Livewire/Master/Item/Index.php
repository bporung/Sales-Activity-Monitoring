<?php

namespace App\Http\Livewire\Master\Item;

use Livewire\Component;
use App\Http\Traits\Component\Pagination\PaginationTrait;

class Index extends Component
{
    use PaginationTrait;
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

        $results = 'App\Models\Item'::orderBy('id','DESC');
        
        if($search){
            $results = $results->where(function($q) use($search){
                    $q->orWhere('name','LIKE','%'.$search.'%')
                    ->orWhere('code','LIKE','%'.$search.'%');
            });
        }
        $results = $results->paginate($per_page, ['*'], 'page', $current_page);

        return $results;
    }

    public function render()
    {
        return view('livewire.master.item.index',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'Item' , 'link' => '/item'],
                ['title' => 'Create' , 'link' => ''],
            ],
        'navigationTab' => [
            ['title' => 'all' , 'link' => '/item' , 'status' => '1'],
            ['title' => 'create' , 'link' => '/item/create' , 'status' => '0'],
        ]
        ]);
    }
}
