<?php

namespace App\Http\Livewire\Component\Form\Selector;

use Livewire\Component;
use Illuminate\Support\Arr;

class Singleselector extends Component
{
    public $groupComponentName = '';
    public $componentName = 'selector';
    public $modelName = '';
    public $modelCondition = [];

    public $searchColumns = ['name'];
    public $scopeSearching = FALSE;
    
    public $search = '';
    public $selectedItem = [];
    
    public $selectedItemId = '';
    public $rows = [];

    
    public $exclusionItemId = [];

    protected function getListeners()
    {
        return [
            'updatedExclusionIDS-to-'.$this->groupComponentName => 'updateexclusionIDS',
        ];
    }
    public function updateexclusionIDS($items){
        $this->reset(['exclusionItemId']);
        $this->exclusionItemId = $items;
    }
    public function getRows(){
        if($this->modelName){
            $results = $this->modelName::orderBy('id','ASC');
            if($this->searchColumns){
                $search = $this->search;
                if($this->scopeSearching){
                    $results = $results->searching($search);
                }else{
                    $results = $results->where(function($q) use($search){
                        foreach($this->searchColumns as $column){
                            $q->orWhere($column,'LIKE','%'.$search.'%');
                        }
                    });
                }
            }
            if($this->selectedItemId){
                $results = $results->where('id','!=',$this->selectedItemId);
            }
            if($this->exclusionItemId){
                $results = $results->whereNotIn('id',$this->exclusionItemId);
            }
            if($this->modelCondition){
                $modelConditions = $this->modelCondition;
                $results = $results->where(function($q) use($modelConditions){
                    foreach($modelConditions as $keyCond => $modelCondition){
                            $q->where($keyCond,$modelCondition);
                    }
                });
            }
            $this->rows = $results->get()->toArray();
        }

    }
    public function selectItem($keyRow){
        $this->selectedItem = $this->rows[$keyRow];
        $this->selectedItemId = $this->rows[$keyRow]['id'];

        $this->emitUp('itemsAdded',$this->componentName,$this->groupComponentName,[$this->selectedItemId]);
        $this->reset(['search']);
    }
    public function deleteItem(){
        $this->reset(['selectedItem','selectedItemId']);
        $this->emitUp('itemsAdded',$this->componentName,$this->groupComponentName,[$this->selectedItemId]);
    }
    
    public function updatedSearch(){
        if(strlen($this->search) > 2){
            $this->getRows();
        }
    }
    public function render()
    {
        return view('livewire.component.form.selector.singleselector');
    }
}
