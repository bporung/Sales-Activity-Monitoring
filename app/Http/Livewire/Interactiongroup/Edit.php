<?php

namespace App\Http\Livewire\Interactiongroup;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Component\Form\AllSelectorTrait;
use App\Http\Traits\InteractionGroupTrait;

class Edit extends Component
{
    use AllSelectorTrait , InteractionGroupTrait;
    public $data_id;
    public $interactiongroup;
    public $result;
    public $customer;
    public $customer_id;
    public $state = [];

    public function mount($customer_id,$id){
        $this->customer_id = $customer_id;
        $this->customer = 'App\Models\Customer'::findOrFail($customer_id);
        $this->state['customer_id'] = $customer_id;

        $result = 'App\Models\InteractionGroup'::with(['users'])->findOrFail($id);
        $this->result = $result;
        $this->data_id = $id;
        $this->fill(['state' => $result->toArray()]);

        $componentName = 'UserMultiSelector';
        $groupComponentName = 'UserMultiSelector';
        $itemIDS = $result->users()->pluck('id')->toArray();
        $this->setSelectorComponent($componentName , $groupComponentName , $itemIDS);

        $this->preparationDatas();
    }
    public function preparationDatas(){
        
    }
    public function submit()
    {
        $this->state['hasusers'] = $this->returnMultiSelectorComponent('UserMultiSelector');
        $validatedData = Validator::make(
            $this->state,
            [
                'customer_id' => 'required',
                'name' => 'required',
                'description' => 'nullable',
                //'hasusers' => 'required',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
                'min' => ':attribute tidak valid',
            ],
            [
                'customer_id' => 'Customer',
                'name' => 'Name',
                'description' => 'Description',
                'hasusers' => 'User',
            ],
        )->validate();
        $res = $this->editInteractionGroup($this->state)->getData();
        if($res && $res->status === 200){
            session()->flash('success', $res->message);
            if($res->redirect_link){
                return redirect()->to($res->redirect_link);
            }
        }else{
            session()->flash('error','There is some error occured');
            if($res->redirect_link){
                return redirect()->to($res->redirect_link);
            }
        }
        
    }

    public function render()
    {
        return view('livewire.interactiongroup.edit',[

        ])
        ->layout('layouts.app', [
        'pagetitle' => [
            ['title' => 'Customer' , 'link' => '/customer'],
            ['title' => $this->customer_id , 'link' => '/customer/'.$this->customer_id],
            ['title' => 'Group:'.substr($this->result->name,0,20).'...' , 'link' => '/customer/'.$this->customer_id.'/interactiongroup/'.$this->data_id],
            ['title' => 'Edit' , 'link' => ''],
        ] , 
        'navigationTab' => [
            ['title' => $this->customer_id , 'link' => '/customer/'.$this->customer_id , 'status' => '0'],
            ['title' => 'Info:Group' , 'link' => '/customer/'.$this->customer_id.'/interactiongroup/'.$this->data_id , 'status' => '0'],
            ['title' => 'Edit:Group' , 'link' => '/customer/'.$this->customer_id.'/interactiongroup/'.$this->data_id.'/edit' , 'status' => '1'],
        ]
        ]);
    }
}
