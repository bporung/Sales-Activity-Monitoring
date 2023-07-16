<?php

namespace App\Http\Traits\Component\Form;

trait SelectorTrait {

    public $selectorComponent = [];

    protected function getListeners()
    {
        return [
            'itemsAdded' => 'setSelectorComponent',
            'updatedSearch' => 'updateRows',
        ];
    }

    public function updateRows($componentName , $fetchFunctionName , $search , $exclutionMode){
        if($fetchFunctionName){
            $rows = $this->{$fetchFunctionName}($search);

            if($exclutionMode){
                if(isset($this->selectorComponent[$componentName]) && $this->selectorComponent[$componentName]){
                    $rows = $rows->whereNotIn('id',$this->selectorComponent[$componentName]);
                }
            }
            $rows = $rows->toArray();

            $this->emit('updatedRows'.$componentName,$rows);
        }
    }

    public function setSelectorComponent($componentName , $item){
        $this->selectorComponent[$componentName] = $item;
    }
    

    protected function returnSelectorComponent($componentName){
        if(isset($this->selectorComponent[$componentName]) && $this->selectorComponent[$componentName]){
            return $this->selectorComponent[$componentName];
        }

        return [];
    }

}