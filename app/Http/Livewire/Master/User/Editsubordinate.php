<?php

namespace App\Http\Livewire\Master\User;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\UserTrait;
use App\Http\Traits\Component\Form\AllSelectorTrait;

class Editsubordinate extends Component
{
    use AllSelectorTrait , UserTrait;

    public $data_id;
    public $username;
    public $state = [];

    public $selectedSubordinates = [];


    public function mount($id){
        $this->data_id = $id;

        $result = 'App\Models\User'::findOrFail($id);
        $this->username = $result->username;
        $this->fill(['state' => $result->toArray()]);
        $this->state['subordinates'] = $result->usersubordinates()->pluck('subordinate_id')->toArray();

        foreach($result->usersubordinates as $sub){
            $this->selectedSubordinates[] = $sub->subordinate;
        }
        $componentName = 'SubordinateMultiSelector';
        $this->setSelectorComponent($componentName , $componentName , $this->state['subordinates']);

    }

    public function submit()
    {
        $this->state['subordinates'] = $this->returnMultiSelectorComponent('SubordinateMultiSelector');

        $validatedData = Validator::make(
            $this->state,
            [
                'id' => 'required',
                'subordinates' => 'nullable',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
            ],
            [
                'subordinates' => 'Subordinate',
            ],
        )->validate();
        $res = $this->editSubordinateUser($this->state)->getData();
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
        return view('livewire.master.user.editsubordinate',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'User' , 'link' => '/user'],
                ['title' => $this->username , 'link' => '/user/'.$this->data_id],
                ['title' => 'Edit Subordinate' , 'link' => ''],
            ], 
        'navigationTab' => [
            ['title' => 'Info' , 'link' => '/user/'.$this->data_id , 'status' => '0'],
            ['title' => 'Edit' , 'link' => '/user/'.$this->data_id.'/edit' , 'status' => '0'],
            ['title' => 'Change password' , 'link' => '/user/'.$this->data_id.'/editpassword' , 'status' => '0'],
            ['title' => 'Edit subordinate' , 'link' => '/user/'.$this->data_id.'/editsubordinate' , 'status' => '1'],
        ]
        ]);
    }
}
