<?php

namespace App\Http\Livewire\Interactiongroup;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Component\Form\AllSelectorTrait;
use App\Http\Traits\InteractionGroupTrait;
use Auth;
class Create extends Component
{
    use AllSelectorTrait , InteractionGroupTrait;
    public $customer;
    public $customer_id;
    public $state = [];

    public function mount($customer_id){
        $this->customer_id = $customer_id;
        $this->customer = 'App\Models\Customer'::findOrFail($customer_id);
        $this->state['customer_id'] = $customer_id;
        $this->state['users'] = [Auth::user()->id];
        $this->selectorComponent['UserMultiSelector'] = $this->state['users'];

        $this->preparationDatas();
    }
    public function preparationDatas(){
        
    }
    public function submit()
    {
        $this->state['users'] = $this->returnMultiSelectorComponent('UserMultiSelector');
        
        $validatedData = Validator::make(
            $this->state,
            [
                'customer_id' => 'required',
                'name' => 'required',
                'description' => 'nullable',
                'users' => 'required',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
                'min' => ':attribute tidak valid',
            ],
            [
                'customer_id' => 'Customer',
                'name' => 'Name',
                'description' => 'Description',
                'users' => 'User',
            ],
        )->validate();
        $res = $this->createInteractionGroup($this->state)->getData();
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
        return view('livewire.interactiongroup.create',[

        ])
        ->layout('layouts.app', [
        'pagetitle' => [
            ['title' => 'Customer' , 'link' => '/customer'],
            ['title' => $this->customer_id , 'link' => '/customer/'.$this->customer_id],
            ['title' => 'Group:Create' , 'link' => ''],
        ] , 
        'navigationTab' => [
            ['title' => $this->customer_id , 'link' => '/customer/'.$this->customer_id , 'status' => '0'],
            ['title' => 'Create:Group' , 'link' => '/customer/'.$this->customer_id.'/interactiongroup/create' , 'status' => '1'],
        ]
        ]);
    }
}
