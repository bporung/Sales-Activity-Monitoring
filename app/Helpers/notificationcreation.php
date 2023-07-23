<?php

use App\Models\Notification;
use App\Models\NotificationReader;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Events\NotificationUpdated;
if(!function_exists('create_notification_by_type')){

    function create_notification_by_type($type,$objectData){
        $getSubjects = set_notification_details($type,$objectData);

        $createItem = Notification::create([
            'subject' => $getSubjects['subject'],
            'description' => $getSubjects['description'],
            'link' => $getSubjects['link'],
        ]);

        $array_all = set_notification_readers($type,$objectData);

        foreach($array_all as $userID){
            $createReader = $createItem->readers()->create([
                'user_id' => $userID,
            ]);
        }
        event(new NotificationUpdated);

        return true;
    }
    function set_notification_readers($type,$objectData){
        $users = [];
        $userRoles = ['Super Admin'];
        $userPermissions = [];



        // REPORT USER PERFORMANCE
        if($type == 'create_reportuserperformance'){
            $users = $objectData->registered && $objectData->registered->usersuperiors ? $objectData->registered->usersuperiors->pluck('id')->toArray() : [];
            $userPermissions =  [];
            $userRoles = get_users_by_roles(['Super Admin','Manager']);
        }


        // INTERACTION
        if($type == 'create_interaction'){
            $users = $objectData->registered && $objectData->registered->usersuperiors ? $objectData->registered->usersuperiors->pluck('id')->toArray() : [];
            $userPermissions =  get_users_by_permissions(['finalize all interaction']);
            $userRoles = get_users_by_roles(['Super Admin']);
        }
        if($type == 'edit_interaction'){
            $users = $objectData->registered && $objectData->registered->usersuperiors ? $objectData->registered->usersuperiors->pluck('id')->toArray() : [];
            $userPermissions =  get_users_by_permissions(['finalize all interaction']);
            $userRoles = get_users_by_roles(['Super Admin']);
        }
        if($type == 'finalize_interaction'){
            $users = $objectData->registered ? [$objectData->registered_by] : [];
            $userPermissions =  [];
            $userRoles = get_users_by_roles(['Super Admin']);
        }

        // QUOTATION
        if($type == 'create_quotation'){
            $users = $objectData->registered && $objectData->registered->usersuperiors ? $objectData->registered->usersuperiors->pluck('id')->toArray() : [];
            $userPermissions =  get_users_by_permissions(['finalize all quotation']);
            $userRoles = get_users_by_roles(['Super Admin']);
        }
        if($type == 'edit_quotation'){
            $users = $objectData->registered && $objectData->registered->usersuperiors ? $objectData->registered->usersuperiors->pluck('id')->toArray() : [];
            $userPermissions =  get_users_by_permissions(['finalize all quotation']);
            $userRoles = get_users_by_roles(['Super Admin']);
        }
        if($type == 'finalize_quotation'){
            $users = $objectData->registered ? [$objectData->registered_by] : [];
            $userPermissions =  [];
            $userRoles = get_users_by_roles(['Super Admin']);
        }

        // SALESORDER
        if($type == 'create_salesorder'){
            $users = $objectData->registered && $objectData->registered->usersuperiors ? $objectData->registered->usersuperiors->pluck('id')->toArray() : [];
            $userPermissions =  get_users_by_permissions(['finalize all salesorder']);
            $userRoles = get_users_by_roles(['Super Admin']);
        }
        if($type == 'edit_salesorder'){
            $users = $objectData->registered && $objectData->registered->usersuperiors ? $objectData->registered->usersuperiors->pluck('id')->toArray() : [];
            $userPermissions =  get_users_by_permissions(['finalize all salesorder']);
            $userRoles = get_users_by_roles(['Super Admin']);
        }
        if($type == 'finalize_salesorder'){
            $users = $objectData->registered ? [$objectData->registered_by] : [];
            $userPermissions =  [];
            $userRoles = get_users_by_roles(['Super Admin']);
        }
        if($type == 'update_status_salesorder'){
            $users = $objectData->salesorderdetail->salesorder->registered ? [$objectData->salesorderdetail->salesorder->registered_by] : [];
            $userPermissions =  [];
            $userRoles = get_users_by_roles(['Super Admin']);
        }
    

        $array_first = array_unique(array_merge($users,$userRoles), SORT_REGULAR);
        $array_all = array_unique(array_merge($array_first,$userPermissions), SORT_REGULAR);

        return $array_all;
        
    }

    function set_notification_details($type,$objectData){
        $subjectDatas = [];
        $subjectDatas['subject'] = '';
        $subjectDatas['description'] = '';
        $subjectDatas['link'] = '';


        
        // REPORT USER PERFORMANCE
        if($type == 'create_reportuserperformance'){
            $subjectDatas['subject'] = 'Report User Performance '.$objectData->report_name;
            $subjectDatas['description'] = 'New Report User Performance Has Been Created : '.$objectData->report_name.'(Period : '.$objectData->start_date.' to '.$objectData->end_date.')';
            $subjectDatas['link'] = '/report/user/performances/'.$objectData->id;
        }


        // INTERACTION
        if($type == 'create_interaction'){
            $subjectDatas['subject'] = 'Interaction Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.')';
            $subjectDatas['description'] = 'Interaction has been created with Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.') by '.$objectData->registered->name;
            $subjectDatas['link'] = '/customer/'.$objectData->customer_id.'/interaction/'.$objectData->id;
        }
        if($type == 'edit_interaction'){
            $subjectDatas['subject'] = 'Interaction Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.')';
            $subjectDatas['description'] = 'Interaction has been updated with Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.') by '.$objectData->registered->name;
            $subjectDatas['link'] = '/customer/'.$objectData->customer_id.'/interaction/'.$objectData->id;
        }
        if($type == 'finalize_interaction'){
            $subjectDatas['subject'] = 'Interaction Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.')';
            $subjectDatas['description'] = 'Interaction has been finalized with Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.') by '.$objectData->finalized->name;
            $subjectDatas['link'] = '/customer/'.$objectData->customer_id.'/interaction/'.$objectData->id;
        }

        // QUOTATION
        if($type == 'create_quotation'){
            $subjectDatas['subject'] = 'Quotation '.$objectData->id.' Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.')';
            $subjectDatas['description'] = 'Quotation '.$objectData->id.' has been created with Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.') by '.$objectData->registered->name;
            $subjectDatas['link'] = '/quotation/'.$objectData->id;
        }
        if($type == 'edit_quotation'){
            $subjectDatas['subject'] = 'Quotation '.$objectData->id.' Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.')';
            $subjectDatas['description'] = 'Quotation '.$objectData->id.' has been updated with Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.') by '.$objectData->registered->name;
            $subjectDatas['link'] = '/quotation/'.$objectData->id;
        }
        if($type == 'finalize_quotation'){
            $subjectDatas['subject'] = 'Quotation '.$objectData->id.' Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.')';
            $subjectDatas['description'] = 'Quotation '.$objectData->id.' has been finalized with Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.') by '.$objectData->registered->name;
            $subjectDatas['link'] = '/quotation/'.$objectData->id;
        }

        // SALESORDER
        if($type == 'create_salesorder'){
            $subjectDatas['subject'] = 'Sales Order '.$objectData->id.' Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.')';
            $subjectDatas['description'] = 'Sales Order '.$objectData->id.' has been created with Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.') by '.$objectData->registered->name;
            $subjectDatas['link'] = '/salesorder/'.$objectData->id;
        }
        if($type == 'edit_salesorder'){
            $subjectDatas['subject'] = 'Sales Order '.$objectData->id.' Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.')';
            $subjectDatas['description'] = 'Sales Order '.$objectData->id.' has been updated with Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.') by '.$objectData->registered->name;
            $subjectDatas['link'] = '/salesorder/'.$objectData->id;
        }
        if($type == 'finalize_salesorder'){
            $subjectDatas['subject'] = 'Sales Order '.$objectData->id.' Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.')';
            $subjectDatas['description'] = 'Sales Order '.$objectData->id.' has been finalized with Customer '.$objectData->customer->full_name.'('.$objectData->customer->id.') by '.$objectData->registered->name;
            $subjectDatas['link'] = '/salesorder/'.$objectData->id;
        }
        if($type == 'update_status_salesorder'){
            $subjectDatas['subject'] = 'Sales Order '.$objectData->salesorderdetail->salesorder_id.' Customer '.$objectData->salesorderdetail->salesorder->customer->full_name.'('.$objectData->salesorderdetail->salesorder->customer->id.')';
            $subjectDatas['description'] = 'Sales Order '.$objectData->salesorderdetail->salesorder_id.' item(s) status has been updated with Customer '.$objectData->salesorderdetail->salesorder->customer->full_name.'('.$objectData->salesorderdetail->salesorder->customer->id.') by '.$objectData->registered->name;
            $subjectDatas['link'] = '/salesorder/'.$objectData->salesorderdetail->salesorder_id;
        }

        return $subjectDatas;
    }


    
    function get_users_by_permissions($permissions){
        $userPermissions = [];
        if($permissions){
            $userPermissions = User::permission($permissions)->get();
            if($userPermissions->count()){
                $userPermissions = $userPermissions->pluck('id')->toArray();
            }else{
                $userPermissions = [];
            }
        }

        return $userPermissions;
    }
    function get_users_by_roles($roles){
        $userRoles = [];
        if($roles){
            $userRoles = User::role($roles)->get();
            if($userRoles->count()){
                $userRoles = $userRoles->pluck('id')->toArray();
            }else{
                $userRoles = [];
            }
        }
        return $userRoles;
    }

}