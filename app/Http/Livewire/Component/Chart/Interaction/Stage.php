<?php

namespace App\Http\Livewire\Component\Chart\Interaction;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class Stage extends Component
{
    public function mount(){
    }
    public function setColumnChartModel(){

        // $thisMonth = date('m',strtotime(now()));
        // $thisMonthYearLabel = date('M Y',strtotime(now()));
        // $thisYear = date('Y',strtotime(now()));


        $thisMonth = '12';
        $thisMonthYearLabel = 'December 2022';
        $thisYear = '2022';

        
        $results = 'App\Models\Stage'::orderBy('id','ASC')->get();
        $columnChartModel = $results->groupBy('id')
            ->reduce(function (ColumnChartModel $columnChartModel, $data) use($thisMonth,$thisYear){
                $stage = $data->first()->name;
                $value = $data->first()->interactions()->where(function($q) use($thisMonth,$thisYear){
                    $q->whereMonth('created_at',$thisMonth)->whereYear('created_at',$thisYear);
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
        return view('livewire.component.chart.interaction.stage',[
            'dataChartModel' => $dataChartModel
        ]);
    }
}
