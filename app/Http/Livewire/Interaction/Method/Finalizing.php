<?php

namespace App\Http\Livewire\Interaction\Method;

use App\Http\Livewire\Component\Modal\Modal;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\InteractionTrait;
use Auth;
class Finalizing extends Modal
{
    use InteractionTrait;
    public $data_id;
    public $customer_id;
    public $state = [];

    public function finalizeData(){
        $this->data_id = isset($this->result) && $this->result && $this->result['id'] ? $this->result['id'] : '';
        $this->customer_id = isset($this->result) && $this->result && $this->result['customer_id'] ? $this->result['customer_id'] : '';
        $this->state['id'] = isset($this->result) && $this->result && $this->result['id'] ? $this->result['id'] : '';
        $this->state['customer_id'] = isset($this->result) && $this->result && $this->result['customer_id'] ? $this->result['customer_id'] : '';

        $validatedData = Validator::make(
            $this->state,
            [
                'id' => 'required',
                'customer_id' => 'required',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
            ],
            [
                'id' => 'ID',
                'customer_id' => 'Customer',
            ],
        )->validate();
        
        $res = $this->finalizeInteraction($this->state)->getData();
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
        return view('livewire.interaction.method.finalizing');
    }
}
