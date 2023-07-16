<?php

namespace App\Http\Livewire\Component\Chart\Interaction;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Carbon\Carbon;
class Monthlyreach extends Component
{
    public function mount(){

    }
    public function setLineChartModel(){
        $results = [];
        for($x = 1 ; $x <= 12 ; $x++){
            $i = 12 - $x;
            $useDate = Carbon::now()->subMonths($i);
            $thisMonth = date('m',strtotime($useDate));
            $thisLabel = date('M Y',strtotime($useDate));
            $thisYear = date('Y',strtotime($useDate));
            $countResult = 'App\Models\Interaction'::whereMonth('created_at',$thisMonth)->whereYear('created_at',$thisYear)->count();
            $results[$x] = [
                'name' => $thisLabel,
                'interactions' => $countResult,
            ];
        }

        $lineChartModel = (new LineChartModel())
        ->setTitle('Interaction Reach Last 12 Months')
        ->setAnimated(true)
        ;

        foreach($results as $key => $result){
            $lineChartModel = $lineChartModel->addPoint($result['name'] , $result['interactions']);
        }


        return $lineChartModel;
    }
    public function render()
    {
        $dataChartModel = $this->setLineChartModel();
        return view('livewire.component.chart.interaction.monthlyreach',[
            'dataChartModel' => $dataChartModel
        ]);
    }
}
