<?php

namespace App\Http\Traits;

trait TestSelector {

    public $selectorComponent = [];

    protected function getListeners()
    {
        return [
            'itemsAdded' => 'setSelectorComponent',
            'updatedSearch' => 'updateRows',
        ];
    }

    public function updateRows($componentName , $fetchFunctionName , $search){
        if($fetchFunctionName){
            $rows = $this->{$fetchFunctionName}($search);
            $this->emit('updatedRows'.$componentName,$rows);
        }
    }

    public function setSelectorComponent($componentName , $items){
        $this->selectorComponent[$componentName] = $items;
    }
    

    protected function returnSelectorComponent($componentName){
        if(isset($this->selectorComponent[$componentName]) && $this->selectorComponent[$componentName]){
            return $this->selectorComponent[$componentName];
        }

        return [];
    }

}