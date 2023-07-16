<?php

namespace App\Http\Traits;
use App\Models\User;
use App\Models\SalesBaseScore;
use App\Models\Customer;
use App\Models\ReportUserPerformance;
use App\Models\ReportUserPerformanceDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;
trait ReportUserPerformanceTrait {

    protected function createReportUserPerformance($state){

        $report_name = $state['report_name'];
        $start_date = $state['start_date'];
        $end_date = $state['end_date'];

        // Get All User -> Roles : Sales
        $sales = User::role('sales')->get();
        $mappedSales = [];
        foreach ($sales as $obj) {
            $mappedSales[$obj->id] = [
                'id' => $obj->id,
                'name' => $obj->name,
                'username' => $obj->username,
                'interaction_target' => $obj->interaction_target,
                'interaction_actual' => 0,
                'interaction_rate' => 100,
                'sales_target' => $obj->sales_target,
                'sales_actual' => 0,
                'sales_rate' => 100,
                'net_sales_actual' => 0,
                'customer_target' => $obj->customer_target,
                'customer_actual' => 0,
                'customer_rate' => 100,
                'quotation_actual' => 0,
                'net_quotation_actual' => 0,
                'conversion_rate' => 0,
                'interaction_score' => 0,
                'sales_score' => 0,
                'customer_score' => 0,
                'conversion_score' => 0,
                'final_score' => 0,
            ];
        }

        // Get All Scoring Rule
        $sales_scores = SalesBaseScore::where('score_category','Sales')->orderBy('id','ASC')->get();
        $new_customer_scores = SalesBaseScore::where('score_category','New Customer')->orderBy('id','ASC')->get();
        $interaction_scores = SalesBaseScore::where('score_category','Interaction')->orderBy('id','ASC')->get();
        $conversion_scores = SalesBaseScore::where('score_category','Conversion')->orderBy('id','ASC')->get();


        // Get Interaction Datas Group by users
        $results = DB::select(DB::raw('
                            SELECT i.registered_by as sales_id, i.stage_id , count(DISTINCT(i.id)) as count_interaction, sum(i2.unit_price * i2.qty) as total_price , 
                            sum(it.unit_price * i2.qty) as total_base_price from interactions i 
                            LEFT JOIN interactiondetails i2 on i.id = i2.interaction_id 
                            LEFT JOIN items it on i2.item_id  = it.id 
                            WHERE i.finalized_at is not null
                            AND i.created_at >= :start_date 
                            AND i.created_at <= :end_date
                            GROUP BY i.registered_by , i.stage_id
                '), ['start_date' => $start_date,'end_date' => $end_date]);


        // SET MAPPING VALUE -> SALES to ACTUAL INTERACTIONS
        foreach ($results as $row){
            if (array_key_exists($row->sales_id, $mappedSales)) {

                $mappedSales[$row->sales_id]['interaction_actual'] += $row->count_interaction;

                if($row->stage_id == '4'){
                    $mappedSales[$row->sales_id]['quotation_actual'] += $row->total_price;
                    $mappedSales[$row->sales_id]['net_quotation_actual'] += $row->total_base_price;
                }
                if($row->stage_id == '5'){
                    $mappedSales[$row->sales_id]['sales_actual'] += $row->total_price;
                    $mappedSales[$row->sales_id]['net_sales_actual'] += $row->total_base_price;
                }
            }
            
        }


        // Get Customer Datas Group by users
        $customerresults = DB::select(DB::raw('
                            select registered_by as sales_id,count(id) as total_new_customer from customers c 
                            WHERE created_at >= :start_date 
                            AND created_at <= :end_date
                            group by registered_by
                '), ['start_date' => $start_date,'end_date' => $end_date]);

        // SET MAPPING VALUE -> SALES to ACTUAL INTERACTIONS
        foreach ($customerresults as $customerrow){
            if (array_key_exists($customerrow->sales_id, $mappedSales)) {
                $mappedSales[$customerrow->sales_id]['customer_actual'] += $customerrow->total_new_customer;
            }
        }


        // SET SCORES
        foreach ($mappedSales as $keySetScore => $valueSetScore) {
                // SET RATE
                if($mappedSales[$keySetScore]['interaction_target']){
                    $mappedSales[$keySetScore]['interaction_rate'] = ($mappedSales[$keySetScore]['interaction_actual'] / $mappedSales[$keySetScore]['interaction_target']) * 100;
                }

                if($mappedSales[$keySetScore]['sales_target']){
                    $mappedSales[$keySetScore]['sales_rate'] = ($mappedSales[$keySetScore]['sales_actual'] / $mappedSales[$keySetScore]['sales_target']) * 100;
                }

                if ($mappedSales[$keySetScore]['customer_target'] > 0){
                    $mappedSales[$keySetScore]['customer_rate'] = ($mappedSales[$keySetScore]['customer_actual'] / $mappedSales[$keySetScore]['customer_target']) * 100;
                }
                if ($mappedSales[$keySetScore]['quotation_actual'] > 0 AND $mappedSales[$keySetScore]['sales_actual'] > 0){
                    $mappedSales[$keySetScore]['conversion_rate'] = ($mappedSales[$keySetScore]['sales_actual'] / $mappedSales[$keySetScore]['quotation_actual']) * 100;
                }
                if ($mappedSales[$keySetScore]['quotation_actual'] == 0 AND $mappedSales[$keySetScore]['sales_actual'] > 0){
                    $mappedSales[$keySetScore]['conversion_rate'] = 100;
                }



                // SET SALES SCORE
                        $mappedSales[$keySetScore]['sales_score'] = $mappedSales[$keySetScore]['sales_rate'] > 100 ? 100 / 100 : $mappedSales[$keySetScore]['sales_rate'] / 100;
                // SET INTERACTION SCORE
                        $mappedSales[$keySetScore]['interaction_score'] = $mappedSales[$keySetScore]['interaction_rate'] > 100 ? 100 / 100 : $mappedSales[$keySetScore]['interaction_rate'] / 100;
                // SET CONVERSION SCORE
                        $mappedSales[$keySetScore]['conversion_score'] = $mappedSales[$keySetScore]['conversion_rate'] > 100 ? 100 / 100 : $mappedSales[$keySetScore]['conversion_rate'] / 100;
                // SET CUSTOMER SCORE
                        $mappedSales[$keySetScore]['customer_score'] = $mappedSales[$keySetScore]['customer_rate'] > 100 ? 100 / 100 : $mappedSales[$keySetScore]['customer_rate'] / 100;
                
                // SET FINAL SCORE
                $mappedSales[$keySetScore]['final_score'] = 
                        ($mappedSales[$keySetScore]['sales_score'] * 0.5) 
                        + ($mappedSales[$keySetScore]['interaction_score'] * 0.15) 
                        + ($mappedSales[$keySetScore]['customer_score'] * 0.2) 
                        + ($mappedSales[$keySetScore]['conversion_score'] * 0.15);
        }



        // CREATE ReportUserPerformance
        $createReport = ReportUserPerformance::create([
            'report_name' => $state['report_name'],
            'start_date' => $state['start_date'],
            'end_date' => $state['end_date'],
            'created_at' => now(),
            'registered_by' => Auth::user()->id,
        ]);


        // CREATE ReportUserPerformanceDetails
        foreach ($mappedSales as $key => $value) {
            $createReportDetails = ReportUserPerformanceDetail::create([
                'report_user_performance_id' => $createReport->id,
                'user_id' => $key,
                'sales_actual' => $mappedSales[$key]['sales_actual'],
                'sales_target' => $mappedSales[$key]['sales_target'],
                'interaction_actual' => $mappedSales[$key]['interaction_actual'],
                'interaction_target' => $mappedSales[$key]['interaction_target'],
                'customer_actual' => $mappedSales[$key]['customer_actual'],
                'customer_target' => $mappedSales[$key]['customer_target'],
                'prospect_actual' => $mappedSales[$key]['quotation_actual'],
                'conversion_rate' => $mappedSales[$key]['conversion_rate'],
                'sales_score' => $mappedSales[$key]['sales_score'],
                'interaction_score' => $mappedSales[$key]['interaction_score'],
                'customer_score' => $mappedSales[$key]['customer_score'],
                'conversion_score' => $mappedSales[$key]['conversion_score'],
                'final_score' => $mappedSales[$key]['final_score'],
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'User '.$createReport->id.' has been created.',
            'redirect_link' => '/report/user/performances/'.$createReport->id,
        ], 200); 
    }


}