<?php

namespace App\Http\Livewire\Component\Chart\Base\User\Ratio;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class QuotationSalesorder extends Component
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
    public function setPieChartModel(){

        $thisUsers = $this->users;
        $startDate = $this->start_date;
        $endDate = $this->end_date;
        $thisMonthYearLabel = date('d M Y',strtotime($startDate)) .' to '. date('d M Y',strtotime($endDate));

        $results1 = 'App\Models\Quotation'::whereDate('created_at','>=',$startDate)->whereDate('created_at','<=',$endDate)
                            ->whereDoesntHave('salesorder')->whereIn('registered_by',$thisUsers)->count();
        $results2 = 'App\Models\Quotation'::whereDate('created_at','>=',$startDate)->whereDate('created_at','<=',$endDate)
                            ->whereHas('salesorder')->whereIn('registered_by',$thisUsers)->count();
        
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
        return view('livewire.component.chart.base.user.ratio.quotation-salesorder',[
            'dataChartModel' => $dataChartModel
        ]);
    }


}
