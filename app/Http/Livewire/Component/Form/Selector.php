<?php

namespace App\Http\Livewire\Component\Form;

use Livewire\Component;

class Selector extends Component
{
    public $componentName = 'selector';
    public $selectorType = 'multiple';
    public $fetchFunctionName = '';
    public $exclutionMode = false;
    public $exclutionTarget = 'self';
    public $search = '';
    public $rows = [];

    public $items = [];
    public $selectedItems;

    
    protected function getListeners()
    {
        return [
            'updatedRows'.$this->componentName => 'setRows',
        ];
    }
    public function dehydrate(){
        if($this->selectorType == 'single'){
            $this->selectedItems = '';
            foreach($this->items as $item){
                $this->selectedItems = $item['id'];
            }
        }else{
            $this->selectedItems = [];
            foreach($this->items as $item){
                $this->selectedItems[] = $item['id'];
            }
        }

    }
    public function mount(){
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
        if($this->fetchFunctionName){
            $this->emitUp('updatedSearch',$this->componentName,$this->fetchFunctionName,$this->search,$this->exclutionMode);
        }
    }
    public function setRows($rows){
        $this->rows = $rows;
    }
    public function render()
    {
        return view('livewire.component.form.selector');
    }
}
