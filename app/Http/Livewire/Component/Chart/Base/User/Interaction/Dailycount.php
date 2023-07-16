<?php

namespace App\Http\Livewire\Component\Chart\Base\User\Interaction;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Carbon\Carbon;
class Dailycount extends Component
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

        $results = 'App\Models\User'::
        whereIn('id',[$thisUsers])
        ->get();

        $startDateCarbon = new Carbon($startDate);
        $endDateCarbon = new Carbon($endDate);

        $lineChartModel = $results
            ->reduce(function (LineChartModel $lineChartModel, $data) use ($results , $startDateCarbon , $endDateCarbon) {
                $x = 0;
                do{
                    $countInteractions = $data->interactions()->whereNotNull('finalized_at')->whereDate('created_at',$startDateCarbon)->count();
                    $lineChartModel->addSeriesPoint($data->name.'['.$data->username.']' , date('d',strtotime($startDateCarbon)), $countInteractions, ['id' => $data->id]);
                    $startDateCarbon->addDay();
                    $x++;
                }while($startDateCarbon <= $endDateCarbon);
                $startDateCarbon->subDays($x);

                return $lineChartModel;

            }, (new LineChartModel())
            ->setTitle('Expenses Evolution')
            ->setAnimated(true)
            ->withOnPointClickEvent('onPointClick')->multiLine()
            );

        return $lineChartModel;
    }
    public function render()
    {
        $dataChartModel = $this->setColumnChartModel();
        return view('livewire.component.chart.base.user.interaction.dailycount',[
            'dataChartModel' => $dataChartModel
        ]);
    }
}
