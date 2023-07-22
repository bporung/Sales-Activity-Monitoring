<?php

namespace App\Http\Livewire\Interaction;

use Livewire\Component;
use App\Http\Traits\Component\Pagination\PaginationTrait;

class IndexNotFinalized extends Component
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
        $created_date = $this->created_date;
        $search = $this->search;
        $current_page = $this->current_page;
        $per_page = $this->per_page;

        $results = 'App\Models\Interaction'::whereNull('finalized_at')->orderBy('created_at','DESC');
        
        if($created_date){
            if($created_date['start'] && $created_date['end']){
                $results = $results->whereDate('created_at','>=',$created_date['start'])->whereDate('created_at','<=',$created_date['end']);
            }
        }
        if($search){
            $results = $results->where(function($q) use($search){
                    $q->orWhere('description','LIKE','%'.$search.'%')
                    ->orWhere(function($p) use($search){
                        $p->whereHas('customer',function($p) use($search){
                            $p->where('name','LIKE','%'.$search.'%')->orWhere('id','LIKE','%'.$search.'%');
                        });
                    })->orWhere(function($p) use($search){
                        $p->whereHas('registered',function($p) use($search){
                            $p->where('name','LIKE','%'.$search.'%');
                        });
                    });
            });
        }
        $results = $results->paginate($per_page, ['*'], 'page', $current_page);

        return $results;
    }

    public function render()
    {
        return view('livewire.interaction.indexnotfinalized',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'Interaction' , 'link' => '/interaction'],
            ],
        'navigationTab' => [
            ['title' => 'all' , 'link' => '/interaction' , 'status' => '0'],
            ['title' => 'not finalized' , 'link' => '/interaction/not_finalized' , 'status' => '1'],
        ]
        ]);
    }
}
