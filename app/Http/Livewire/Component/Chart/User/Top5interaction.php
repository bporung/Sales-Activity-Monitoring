<?php

namespace App\Http\Livewire\Component\Chart\User;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Auth;
class Top5interaction extends Component
{
    public $color = ['#d88fff','#8c9bfa','#9beef2','#a0f2c2','#f3f59f'];
    public function mount(){
    }
    public function setColumnChartModel(){

        $thisMonth = date('m',strtotime(now()));
        $thisMonthYearLabel = date('M Y',strtotime(now()));
        $thisYear = date('Y',strtotime(now()));
        $results = 'App\Models\User'::role('sales')->orderBy('id','ASC');

        $user = Auth::user();
        $user_id = $user->id;
        if($user->can('read all user')){
            
        }else{
            if($user->can('read self user')){
                    $userArr = [];
                    if(count($user->usersubordinates) > 0){
                        $userArr = $user->usersubordinates->pluck('subordinate_id')->toArray();
                    }
                    array_push($userArr,$user->id);

                    $results = $results->where(function($p) use($userArr,$user_id){
                        $p->whereIn('id',$userArr);
                    });
                    
            }else{
                $results = $results->where(function($p) use($user_id){
                    $p->where('id',$user_id);
                });
            }
        }

        $results = $results->get();
        $userDatas = [];
        $i = 0;
        foreach($results as $user){
            $userDatas[$i] = [
                'id' => $user->id,
                'name' => $user->name,
                'interactions' =>   $user->interactions()->where(function($q) use($thisMonth,$thisYear){
                                        $q->whereMonth('created_at',$thisMonth)->whereYear('created_at',$thisYear);
                                    })->count(),
            ];
            $i++;
        }

        $col = array_column( $userDatas, "interactions" );
        array_multisort( $col, SORT_DESC, $userDatas );
        
        $columnChartModel = 
        (new ColumnChartModel())
        ->setTitle('Interaction Count'.$thisMonthYearLabel)
        ->setAnimated(true)
        ;
        $x = 0;
        foreach($userDatas as $uData){
            if($x < 5){
                $columnChartModel = $columnChartModel->addColumn($uData['name'],$uData['interactions'],$this->color[$x]);
            }else{
                break;
            }
            $x++;
        }


        return $columnChartModel;
    }
    public function render()
    {
        $dataChartModel = $this->setColumnChartModel();

        return view('livewire.component.chart.user.top5interaction',[
            'dataChartModel' => $dataChartModel
        ]);
    }
}
