<?php

namespace App\Http\Livewire\Report\User\Performance;

use Livewire\Component;
use App\Models\ReportUserPerformance;
use App\Models\ReportUserPerformanceDetail;
use Auth;
class Show extends Component
{
    public $result;
    public $results;
    public $data_id;

    
    public function mount($id){
        $this->data_id = $id;
        $this->results = ReportUserPerformanceDetail::where('report_user_performance_id',$id)->orderBy('final_score','DESC')->get();
        $this->result = ReportUserPerformance::findOrFail($id);

        $this->preparationDatas();
    }

    public function preparationDatas(){

    }

    public function render()
    {
        return view('livewire.report.user.performance.show',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'Report' , 'link' => ''],
                ['title' => 'User' , 'link' => ''],
                ['title' => 'Performance' , 'link' => '/report/user/performances'],
                ['title' => $this->result->report_name , 'link' => ''],
            ],
        'navigationTab' => [
        ]
        ]);
    }
}
