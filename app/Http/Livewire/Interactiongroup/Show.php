<?php

namespace App\Http\Livewire\Interactiongroup;

use Livewire\Component;
use App\Http\Traits\InteractionGroupTrait;

use Auth;
class Show extends Component
{
    use InteractionGroupTrait;
    public $data_id;
    public $result;
    public $customer;
    public $customer_id;
    public $interactions;

    public $btnAction = [
        'new_interaction' => false,
        'update_status' => false,
        'edit_interactiongroup' => false,
    ];
    

    public function mount($customer_id,$id){
        $this->customer_id = $customer_id;
        $this->customer = 'App\Models\Customer'::findOrFail($customer_id);

        $result = $this->getInteractionGroup($id);
        $this->data_id = $id;
        $this->result = $result;
        
        $interactions = 'App\Models\Interaction'::with(['group','customer','type','stage','details.item'])->where('group_id',$id)->paginate(10);
        $this->interactions = $interactions->items();
        

        $this->preparationDatas();
    }
    public function preparationDatas(){
        // BTN ACTION
        $user = Auth::user();
        $group_user_list = $this->result->users()->pluck('id')->toArray();
        if($this->result->status == '1'){
            if($user->hasRole('Super Admin')){
                $this->btnAction['new_interaction'] = true;
                $this->btnAction['update_status'] = true;
                $this->btnAction['edit_interactiongroup'] = true;
            }else{
                if($user->can(['edit all interactiongroup'])){
                    $this->btnAction['new_interaction'] = true;
                    $this->btnAction['update_status'] = true;
                    $this->btnAction['edit_interactiongroup'] = true;
                }else{
                    if($user->can(['edit self interactiongroup'])){
                        if(in_array($user->id,$group_user_list)){
                            $this->btnAction['new_interaction'] = true;
                            $this->btnAction['update_status'] = true;
                        }
                    }
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.interactiongroup.show',[

        ])
        ->layout('layouts.app', [
        'pagetitle' => [
            ['title' => 'Customer' , 'link' => '/customer'],
            ['title' => $this->customer_id , 'link' => '/customer/'.$this->customer_id],
            ['title' => 'Group:'.substr($this->result->name,0,20).'...' , 'link' => ''],
        ] , 
        'navigationTab' => [
            ['title' => $this->customer_id , 'link' => '/customer/'.$this->customer_id , 'status' => '0'],
            ['title' => 'Info:Group' , 'link' => '/customer/'.$this->customer_id.'/interactiongroup/'.$this->data_id , 'status' => '1'],
            ['title' => 'Edit:Group' , 'link' => '/customer/'.$this->customer_id.'/interactiongroup/'.$this->data_id.'/edit' , 'status' => '0' , 'visibility' => $this->btnAction['edit_interactiongroup']] ,
        ]
        ]);
    }
}
