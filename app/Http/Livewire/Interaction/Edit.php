<?php

namespace App\Http\Livewire\Interaction;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Component\Form\AllSelectorTrait;
use App\Http\Traits\InteractionTrait;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads , AllSelectorTrait , InteractionTrait;
    public $data_id;
    public $result;
    public $old_images;
    public $customer;
    public $customer_id;
    public $state = [];
    public $createNewGroup = false;
    public $addDetailItems = true;
    public $interactiontypes;
    public $interactionstages;

    public function mount($customer_id,$id){
        
        $result = 'App\Models\Interaction'::with(['details','details.item'])->findOrFail($id);
        $this->result = $result;
        if($result->finalized_at){abort('403');}
        $this->data_id = $id;
        $this->customer_id = $customer_id;
        $this->customer = 'App\Models\Customer'::findOrFail($customer_id);
        if($result->details->count() < 1){$this->addDetailItems = false;}
        $this->old_images = $result->images;
        $result = $result->toArray();
        $this->fill(['state' => $result]);
        $this->state['images'] = [];

        foreach($result['details'] as $keyDetail => $detail){
            $componentName = 'ItemSingleSelector'.$keyDetail;
            $groupComponentName = 'ItemSingleSelector';
            $itemIDS = [$detail['item_id']];
            $this->setSelectorComponent($componentName , $groupComponentName , $itemIDS);
        }

        $this->preparationDatas();
    }
    public function preparationDatas(){
        $this->interactiontypes = 'App\Models\Category'::where('group','InteractionType')->get();
        $this->interactionstages = 'App\Models\Stage'::all();
    }
    public function addItem(){
        $this->state['details'][] = [];
    }
    public function submit()
    {
        // DEFINE DETAILS ITEM
        foreach($this->state['details'] as $keyindex => $detail){
            $this->state['details'][$keyindex]['item_id'] = $this->returnSingleSelectorComponent('ItemSingleSelector'.$keyindex);
        }

        // CHECK STAGE CONDITION
        if(isset($this->state['stage_id'])){
            $this->state['stage'] = 'App\Models\Stage'::findOrFail($this->state['stage_id']);
            if($this->state['stage']['filled_item'] || $this->state['stage']['filled_qty'] || $this->state['stage']['filled_price'])
                $this->addDetailItems = true;
        }
        
        $validatedData = Validator::make(
            $this->state,
            [
                'id' => 'required',
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
        $res = $this->editInteraction($this->state)->getData();
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
        return view('livewire.interaction.edit',[

        ])
        ->layout('layouts.app', [
        'pagetitle' => [
            ['title' => 'Customer' , 'link' => '/customer'],
            ['title' => $this->customer_id , 'link' => '/customer/'.$this->customer_id],
            ['title' => 'Group:'.substr($this->result->group->name,0,20).'...' , 'link' => '/customer/'.$this->customer_id.'/interactiongroup/'.$this->result->group->id],
            ['title' => 'Interaction:'.$this->data_id , 'link' => '/customer/'.$this->customer_id.'/interaction/'.$this->data_id],
            ['title' => 'Edit', 'link' => ''],
        ], 
        'navigationTab' => [
            ['title' => $this->customer_id , 'link' => '/customer/'.$this->customer_id , 'status' => '0'],
            ['title' => 'Group:'.substr($this->result->group->name,0,20).'...' , 'link' => '/customer/'.$this->customer_id.'/interactiongroup/'.$this->result->group->id , 'status' => '0'],
            ['title' => 'Info:Interaction' , 'link' => '/customer/'.$this->customer_id.'/interaction/'.$this->data_id , 'status' => '0'],
            ['title' => 'Edit:Interaction' , 'link' => '' , 'status' => '1'],
        ]
        ]);
    }
}
