<?php

namespace App\Http\Livewire\Report\User\Performance;

use Livewire\Component;
use App\Http\Traits\Component\Pagination\PaginationTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\ReportUserPerformance;
use App\Http\Traits\ReportUserPerformanceTrait;

class Index extends Component
{ 
    use ReportUserPerformanceTrait;
    use PaginationTrait;
    public $results;
    public $state = [];


    public function mount(){

        $this->results = $this->getDatas();
    }
    
    public function getDatas() {
        $result = ReportUserPerformance::orderBy('id','DESC')->get();
        return $result;
    }

    public function submit()
    {

        $validatedData = Validator::make(
            $this->state,
            [
                'report_name' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
            ],
            [
                'report_name' => 'Report Name',
                'start_date' => 'Start Date',
                'end_date' => 'End Date',
            ],
        )->validate();
        $res = $this->createReportUserPerformance($this->state)->getData();
        if($res && $res->status === 200){
            session()->flash('success', $res->message);
            if($res->redirect_link){
                return redirect()->to($res->redirect_link);
            }
        }else{
            session()->flash('error','There is some error occured');
            if($res->redirect_link){
                return redirect()->to($res->redirect_link);
            }
        }
        
    }

    public function render()
    {
        return view('livewire.report.user.performance.index',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'Report' , 'link' => ''],
                ['title' => 'User' , 'link' => ''],
                ['title' => 'Performance' , 'link' => ''],
            ],
        'navigationTab' => [
        ]
        ]);
    }
}
