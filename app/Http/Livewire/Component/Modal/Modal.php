<?php

namespace App\Http\Livewire\Component\Modal;

use Livewire\Component;

class Modal extends Component
{
    public $show = false;
    public $result;

    protected $listeners = [
        'show' => 'show'
    ];

    public function show($val = null){
        $this->show = true;
        $this->result = $val;
    }
    
}
