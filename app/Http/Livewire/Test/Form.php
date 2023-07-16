<?php

namespace App\Http\Livewire\Test;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\TestSelector;


class Form extends Component
{
    use TestSelector;
    public $state = [];


    public function getSkills(){
        $rows = [
            ['id' => 1 , 'label' => 'Itemx 1',],
            ['id' => 2 , 'label' => 'Itemx 2',],
            ['id' => 3 , 'label' => 'Itemx 3',],
            ['id' => 4 , 'label' => 'Itemx 4',],
            ['id' => 5 , 'label' => 'Itemx 5',],
        ];
        return $rows;
    }
    public function submit()
    {
        $this->state['skills'] = $this->returnSelectorComponent('skills');
        $this->state['interests'] = $this->returnSelectorComponent('interests');
        dd($this->state);
        $validatedData = Validator::make(
            $this->state,
            [
                'name' => 'required',
                'email' => 'required|email',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
                'email' => ':attribute tidak valid',
            ],
            [
                'name' => 'Full Name',
                'email' => 'Email Address',
            ],
        )->validate();

        dd($this->state);
        
    }

    public function render()
    {
        return view('livewire.test.form')
        ->layout('layouts.app', ['pagetitle' => 'Test']);
    }
}
