<?php

namespace App\Http\Livewire\Component\Search;

use Livewire\Component;
use App\Http\Traits\Component\Form\AllSelectorTrait;

class SearchV1 extends Component
{
    use AllSelectorTrait;

    public $parentComponent = '';
    public $exportPDF = false;
    public $exportExcel = false;

    public $showAdvancedSearch = false;

    public $users = false;

    public $advSearch = [
        'selectedUsers' => []
    ];

    public $search = '';
    public $readstatus = [
        'is_read' => true,
        'is_not_read' => true,
    ];
    public $readStatusCheckbox = false;

    public $created_date_field = false;
    public $created_date = [
        'start' => '',
        'end' => '',
    ];

    public function updatedSearch(){
        $this->emitTo($this->parentComponent,'updated-search',$this->search);
    }
    public function updatedReadstatus(){
        if($this->readStatusCheckbox){
            $this->emitTo($this->parentComponent,'updated-readstatus',$this->readstatus);
        }
    }
    public function updatedCreatedDate(){
        if($this->created_date_field){
            if(($this->created_date['start'] && $this->created_date['end']  && ($this->created_date['end'] >= $this->created_date['start'])) || (!$this->created_date['start'] && !$this->created_date['end'])){
                $this->emitTo($this->parentComponent,'updated-created_date',$this->created_date);
            }
        }
    }
    public function exportedExcel(){
        $this->emitTo($this->parentComponent,'exported-excel');
    }
    public function exportedPDF(){
        $this->emitTo($this->parentComponent,'exported-pdf');
    }
    public function runAdvancedSearch(){
        if($this->users){
            $this->advSearch['selectedUsers'] = $this->returnMultiSelectorComponent('UserMultiSelector');
        }

        $this->emitTo($this->parentComponent,'updated-advanced-search',$this->advSearch);

        $this->showAdvancedSearch = false;
    }
    public function render()
    {
        return view('livewire.component.search.search-v1');
    }
}
