<?php

namespace App\Http\Livewire\Interaction;

use Livewire\Component;
use App\Http\Traits\InteractionTrait;
use Auth;
class Show extends Component
{
    use InteractionTrait;
    public $result;
    public $customer_id = '';
    public $data_id = '';

    public $btnAction = [
        'edit_interaction' => false,
        'finalize_interaction' => false,
    ];
    
    public function mount($customer_id,$id){
        $this->customer_id = $customer_id;
        $this->data_id = $id;
        $this->result = $this->getInteraction($id);

        $this->preparationDatas();
    }

    public function preparationDatas(){
        $user = Auth::user();
        $userSubs = $user->usersubordinates()->pluck('subordinate_id')->toArray();

        if(!$this->result->finalized_at){
                // CHECK ALL PERMISSION
                if($user->can('edit all interaction')){
                    $this->btnAction['edit_interaction'] = true;
                }
                // CHECK ALL PERMISSION
                if($user->can('finalize all interaction')){
                    $this->btnAction['finalize_interaction'] = true;
                }
                if($user->can('edit self interaction')){
                    // CHECK OWNER
                    if($this->result->registered_by == $user->id){
                        $this->btnAction['edit_interaction'] = true;
                    }
                    // CHECK SUBORDINATE
                    if(in_array($this->result->registered_by,$userSubs)){
                        $this->btnAction['edit_interaction'] = true;
                    }
                }
                if($user->can('finalize self interaction')){
                    // CHECK SUBORDINATE
                    if(in_array($this->result->registered_by,$userSubs)){
                        $this->btnAction['finalize_interaction'] = true;
                    }
                }
        }else{
            
        }


    }

    public function render()
    {
        return view('livewire.interaction.show',[

        ])
        ->layout('layouts.app', [
        'pagetitle' => [
            ['title' => 'Customer' , 'link' => '/customer'],
            ['title' => $this->customer_id , 'link' => '/customer/'.$this->customer_id],
            ['title' => 'Group:'.substr($this->result->group->name,0,20).'...' , 'link' => '/customer/'.$this->customer_id.'/interactiongroup/'.$this->result->group->id],
            ['title' => 'Interaction:'.$this->data_id , 'link' => ''],
        ] , 
        'navigationTab' => [
            ['title' => $this->customer_id , 'link' => '/customer/'.$this->customer_id , 'status' => '0'],
            ['title' => 'Group:'.substr($this->result->group->name,0,20).'...' , 'link' => '/customer/'.$this->customer_id.'/interactiongroup/'.$this->result->group->id , 'status' => '0'],
            ['title' => 'Info:Interaction' , 'link' => '/customer/'.$this->customer_id.'/interactiongroup/'.$this->result->group->id.'/interaction/'.$this->data_id , 'status' => '1'],
            ['title' => 'Edit:Interaction' , 'link' => '/customer/'.$this->customer_id.'/interaction/'.$this->data_id.'/edit' , 'status' => '0' , 'visibility' => $this->btnAction['edit_interaction']],
        ]
        ]);
    }
}
