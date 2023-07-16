<?php

namespace App\Http\Livewire\Component\Test;

use Livewire\Component;

class Selector extends Component
{
    public $componentName = 'selector';
    public $selectorType = 'multiple';
    public $fetchFunctionName = '';
    public $search = '';
    public $rows = [
        ['id' => 1 , 'label' => 'Item 1',],
        ['id' => 2 , 'label' => 'Item 2',],
        ['id' => 3 , 'label' => 'Item 3',],
        ['id' => 4 , 'label' => 'Item 4',],
        ['id' => 5 , 'label' => 'Item 5',],
    ];

    public $items = [];
    public $selectedItems;

    
    protected function getListeners()
    {
        return [
            'updatedRows'.$this->componentName => 'setRows',
        ];
    }
    
    public function mount(){
        if($this->selectorType == 'single'){
            $this->selectedItems = '';
        }else{
            $this->selectedItems = [];
        }
    }
    public function addItem($key){
        if($this->selectorType == 'single'){
            $this->items[0] = $this->rows[$key];
            $this->selectedItems = $this->rows[$key]['id'];
        }else{
            $this->items[] = $this->rows[$key];
            $this->selectedItems[] = $this->rows[$key]['id'];
        }
        
        $this->reset(['search']);
        $this->emitUp('itemsAdded',$this->componentName,$this->selectedItems);
    }
    public function deleteItem($index){
        if($this->selectorType == 'single'){
            $this->items = [];
            $this->selectedItems = '';
        }else{
            array_splice($this->items, $index, 1);
            array_splice($this->selectedItems, $index, 1);
        }

        $this->emitUp('itemsAdded',$this->componentName,$this->selectedItems);
    }

    public function updatedSearch(){
        $this->emitUp('updatedSearch',$this->componentName,$this->fetchFunctionName,$this->search);
    }
    public function setRows($rows){
        $this->rows = $rows;
    }

    public function render()
    {
        return view('livewire.component.test.selector');
    }
}
