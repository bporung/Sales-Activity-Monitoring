<?php

namespace App\Http\Livewire\Interactiongroup\Method;

use App\Http\Livewire\Component\Modal\Modal;
use Auth;

class Changingstatus extends Modal
{
    public $data_id;
    public $state = [];
    public $customer_id;

    public function submitData(){
        $this->data_id = isset($this->result) && $this->result && $this->result['id'] ? $this->result['id'] : '';
        $this->customer_id = isset($this->result) && $this->result && $this->result['customer_id'] ? $this->result['customer_id'] : '';
        $finalizeItem = 'App\Models\InteractionGroup'::findOrFail($this->data_id)->update([
            'status' => 0,
            'updated_by' => Auth::user()->id,
        ]);

        session()->flash('message', 'Interaction Group has been closed.');
        return redirect()->to('/customer/'.$this->customer_id.'/interactiongroup/'.$this->data_id);
    }
    public function render()
    {
        return view('livewire.interactiongroup.method.changingstatus');
    }
}
