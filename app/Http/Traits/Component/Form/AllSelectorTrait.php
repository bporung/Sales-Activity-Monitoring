<?php

namespace App\Http\Traits\Component\Form;
use Illuminate\Support\Arr;

trait AllSelectorTrait {

    public $selectorComponent = [];
    public $groupSelectorComponent = [];
    public $groupFlatten = [];

    protected function getListeners()
    {
        return [
            'itemsAdded' => 'setSelectorComponent',
            'itemsDeleted' => 'setDeletedSelectorComponent',
        ];
    }


    public function setSelectorComponent($componentName , $groupComponentName , $itemIDS){
        $this->selectorComponent[$componentName] = $itemIDS;

        if($groupComponentName){
            if(!isset($this->groupSelectorComponent[$groupComponentName])){
                $this->groupSelectorComponent[$groupComponentName] = [];
                $this->groupSelectorComponent[$groupComponentName][$componentName] = [];
                $this->groupFlatten[$groupComponentName] = [];
            }

                $this->groupSelectorComponent[$groupComponentName][$componentName] = $itemIDS;

                $flattenGroup = $this->groupSelectorComponent[$groupComponentName];

                $this->groupFlatten[$groupComponentName] = Arr::flatten($flattenGroup);
                
            $this->emit('updatedExclusionIDS-to-'.$groupComponentName,$this->groupFlatten[$groupComponentName]);
        }


        if(method_exists($this,'update'.$componentName)) {
            $this->{'update'.$componentName}();
        }
    }
    

    protected function returnSelectorComponent($componentName){
        if(isset($this->selectorComponent[$componentName]) && $this->selectorComponent[$componentName]){
            return $this->selectorComponent[$componentName];
        }
        return [];
    }

    protected function returnSingleSelectorComponent($componentName){
        if(isset($this->selectorComponent[$componentName]) && $this->selectorComponent[$componentName]){
            return $this->selectorComponent[$componentName][0];
        }
        return '';
    }
    protected function returnMultiSelectorComponent($componentName){
        if(isset($this->selectorComponent[$componentName]) && $this->selectorComponent[$componentName]){
            return $this->selectorComponent[$componentName];
        }
        return [];
    }
}