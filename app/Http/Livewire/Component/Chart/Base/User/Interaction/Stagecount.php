<?php

namespace App\Http\Livewire\Component\Chart\Base\User\Interaction;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class Stagecount extends Component
{
    public $users = [];
    public $start_date;
    public $end_date;

    public function mount(){
        $this->preparationDatas();
        
    }
    public function preparationDatas(){
        $thisMonth = date('m',strtotime(now()));
        $thisYear = date('Y',strtotime(now()));
        $thisDate = date('Y-m-d',strtotime(now()));
        $firstDate = $thisYear.'-'.$thisMonth.'-01';

        if(!$this->start_date){
            $this->start_date = $firstDate;
        }
        if(!$this->end_date){
            $this->end_date = $thisDate;
        }
    }
    public function setColumnChartModel(){
        $thisUsers = $this->users;
        $startDate = $this->start_date;
        $endDate = $this->end_date;
        $thisMonthYearLabel = date('d M Y',strtotime($startDate)) .' to '. date('d M Y',strtotime($endDate));

        $results = 'App\Models\Stage'::orderBy('id','ASC')->get();
        $columnChartModel = $results->groupBy('id')
            ->reduce(function (ColumnChartModel $columnChartModel, $data) use($startDate,$endDate,$thisUsers){
                $stage = $data->first()->name;
                $value = $data->first()->interactions()->where(function($q) use($startDate,$endDate,$thisUsers){
                    $q->whereNotNull('finalized_at')->whereDate('created_at','>=',$startDate)->whereDate('created_at','<=',$endDate)->whereIn('registered_by',$thisUsers);
                })->count();
                $color = $data->first()->color_hex;
                return $columnChartModel->addColumn($stage, $value, $color);
            }, 
        (new ColumnChartModel())
        ->setTitle('Interaction Stage '.$thisMonthYearLabel)
        ->setAnimated(true)
        );


        return $columnChartModel;
    }
    public function render()
    {
        $dataChartModel = $this->setColumnChartModel();
        return view('livewire.component.chart.base.user.interaction.stagecount',[
            'dataChartModel' => $dataChartModel
        ]);
    }
}
