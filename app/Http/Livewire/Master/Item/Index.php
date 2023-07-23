<?php

namespace App\Http\Livewire\Master\Item;

use Livewire\Component;
use App\Http\Traits\Component\Pagination\PaginationTrait;
use Auth;
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
        $boolPermissionsCreate = Auth::user()->can('create all item');
        $navTab = [
            ['title' => 'All' , 'link' => '/item' , 'status' => '1'],
        ];
        if($boolPermissionsCreate){
            $navTab[] = ['title' => 'Create' , 'link' => '/item/create' , 'status' => '0'];
        }

        return view('livewire.master.item.index',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'Item' , 'link' => '/item'],
            ],
        'navigationTab' => $navTab
        ]);
    }
}
