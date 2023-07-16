<?php

namespace App\Http\Livewire\Component\Chart\Quotation;

use Livewire\Component;

use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;


class Process extends Component
{
    public function mount(){
    }
    public function setPieChartModel(){

        $thisMonth = date('m',strtotime(now()));
        $thisMonthYearLabel = date('M Y',strtotime(now()));
        $thisYear = date('Y',strtotime(now()));

        $results1 = 'App\Models\Quotation'::whereMonth('created_at',$thisMonth)->whereYear('created_at',$thisYear)
                            ->whereDoesntHave('salesorder')->count();
        $results2 = 'App\Models\Quotation'::whereMonth('created_at',$thisMonth)->whereYear('created_at',$thisYear)
                            ->whereHas('salesorder')->count();
        
        $pieChartModel = (new PieChartModel())
        ->setTitle('Quotation : Sales Order '.$thisMonthYearLabel)
        ->setAnimated(true)
        ->addSlice('Quotation', $results1, '#4083ff')
        ->addSlice('Sales Order' ,  $results2, '#f5ff3b');


        return $pieChartModel;
    }
    public function render()
    {
        $dataChartModel = $this->setPieChartModel();
        return view('livewire.component.chart.quotation.process',[
            'dataChartModel' => $dataChartModel
        ]);
    }
}
