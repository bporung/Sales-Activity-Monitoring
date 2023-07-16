<?php

namespace App\Http\Livewire\Report\User;

use Livewire\Component;
use App\Http\Traits\Component\Pagination\PaginationTrait;

class Index extends Component
{ 
    use PaginationTrait;
    public $results;
    public $interactionDatas;


    public function mount(){
        $created_date = $this->created_date;
        if($created_date){
            if($created_date['start'] && $created_date['end']){
                $startDate = $created_date['start'];
                $endDate = $created_date['end'];
            }
        }

        if($created_date['start'] && $created_date['end']){
            $this->preparationDatas();
        }
    }
    
    public function preparationDatas() {
        $results = $this->getDatas();
        $this->results = $results;

        $created_date = $this->created_date;
        if($created_date){
            if($created_date['start'] && $created_date['end']){
                $startDate = $created_date['start'];
                $endDate = $created_date['end'];
            }
        }


        if($created_date['start'] && $created_date['end']){
            foreach($results as $user){
                $interactions = 'App\Models\Interaction'::where('registered_by',$user->id)->whereNotNull('finalized_at')->whereBetween('created_at', [$startDate, $endDate])->get()->groupBy('stage_id');
                if($interactions->count() < 1){continue;}
                    $interactionDatas[$user->id] = [];
                    $interactionDatas[$user->id]['data'] = $user;
                    foreach($interactions as $key => $value){
                        $interactionDatas[$user->id]['count_per_stage'][$key] = $value->count();
                        if($key == '5'){
                            $interactionDatas[$user->id]['sales'] = 0;
                            foreach($value as $unit){
                                $interactionDatas[$user->id]['sales'] += $unit->details()->selectRaw('SUM(qty * unit_price) as total_amount')->value('total_amount');
                            
                            }
                        }
                    }

            }
            $this->interactionDatas = $interactionDatas;
        }
    }
    public function getDatas() {

        $results = 'App\Models\User'::role('sales')->orderBy('id','DESC')->get();

        return $results;
    }

    public function render()
    {
        return view('livewire.report.user.index',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'Report' , 'link' => ''],
                ['title' => 'User Performance' , 'link' => ''],
            ],
        'navigationTab' => [
        ]
        ]);
    }
}
