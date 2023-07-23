<?php

namespace App\Http\Livewire\Interaction;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Traits\Component\Form\AllSelectorTrait;
use App\Http\Traits\InteractionTrait;
use Livewire\WithFileUploads;
class Create extends Component
{
    use WithFileUploads , AllSelectorTrait , InteractionTrait;
    public $customer;
    public $customer_id;
    public $state = [];
    public $createNewGroup = false;
    public $groupselection = true;
    public $addDetailItems = false;
    public $interactiontypes;
    public $interactionstages;

    public function mount($customer_id){

        if(\Request::get('group_id')){
            $group_id = \Request::get('group_id');
            $group = 'App\Models\InteractionGroup'::findOrFail($group_id);
            if($group->status == '0'){abort('403');}
            $this->state['group_id'] = \Request::get('group_id');
            $this->groupselection = false;
        }
        $this->customer_id = $customer_id;
        $this->customer = 'App\Models\Customer'::findOrFail($customer_id);
        $this->state['customer_id'] = $customer_id;
        
        $this->state['details'] = [];
        $this->state['details'][] = [];

        $this->preparationDatas();
    }
    public function preparationDatas(){
        $this->interactiontypes = 'App\Models\Category'::where('group','InteractionType')->get();
        $this->interactionstages = 'App\Models\Stage'::all();
    }
    public function addItem(){
        $this->state['details'][] = [];
    }
    public function delItem(){
        $countItems = count($this->state['details']);
        if($countItems > 0){
                array_pop($this->state['details']);
        }
    }
    public function submit()
    {
        // DEFINE DETAILS ITEM
        foreach($this->state['details'] as $keyindex => $detail){
            $this->state['details'][$keyindex]['item_id'] = $this->returnSingleSelectorComponent('ItemSingleSelector'.$keyindex);
        }
        $this->state['customer_id'] = $this->customer_id;
        
        
        // CHECK STAGE CONDITION
        if(isset($this->state['stage_id'])){
            $this->state['stage'] = 'App\Models\Stage'::findOrFail($this->state['stage_id']);
            if($this->state['stage']['filled_item'] || $this->state['stage']['filled_qty'] || $this->state['stage']['filled_price'])
                $this->addDetailItems = true;
        }

        
        $validatedData = Validator::make(
            $this->state,
            [
                'customer_id' => 'required',
                'type_id' => 'required',
                'stage_id' => 'required',
                'description' => 'required',
                'createNewGroup' => 'nullable',
                'group_name' => 'required_if:createNewGroup,true',
                'group_id' => 'required_unless:createNewGroup,true',
                'images.*' => 'nullable|image|max:5024',
                'details.*.item_id' => 'required_if:stage.filled_item,1',
                'details.*.qty' => 'required_if:stage.filled_qty,1|numeric|min:1',
                'details.*.unit_price' => 'required_if:stage.filled_price,1|numeric',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
                'required_if' => ':attribute tidak boleh kosong',
                'required_unless' => ':attribute tidak boleh kosong',
                'required_with' => ':attribute tidak boleh kosong',
                'numeric' => ':attribute format tidak valid',
                'min' => ':attribute tidak valid',
                'image' => ':attribute tidak valid',
            ],
            [
                'customer_id' => 'Customer',
                'type_id' => 'Type',
                'stage_id' => 'Stage',
                'description' => 'Description',
                'group_name' => 'New Group Name',
                'group_id' => 'Group',
                'images' => 'Image',
                'details.*.item_id' => 'Item',
                'details.*.qty' => 'Qty',
                'details.*.unit_price' => 'Unit Price',
            ],
        )->validate();


        $res = $this->createInteraction($this->state)->getData();
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
        return view('livewire.interaction.create',[

        ])
        ->layout('layouts.app', [
        'pagetitle' => [
            ['title' => 'Customer' , 'link' => '/customer'],
            ['title' => $this->customer_id , 'link' => '/customer/'.$this->customer_id],
            ['title' => 'Interaction:Create', 'link' => ''],
        ] , 
        'navigationTab' => [
            ['title' => $this->customer_id , 'link' => '/customer/'.$this->customer_id , 'status' => '0'],
            ['title' => 'Create:Interaction '.$this->customer_id , 'link' => '/customer/'.$this->customer_id.'/interaction/create' , 'status' => '1'],
        ]
        ]);
    }
}
