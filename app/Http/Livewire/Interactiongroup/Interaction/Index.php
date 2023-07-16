<?php

namespace App\Http\Livewire\Interactiongroup\Interaction;

use Livewire\Component;
use App\Http\Traits\Component\Pagination\PaginationTrait;
use App\Http\Traits\InteractionTrait;

class Index extends Component
{
    use PaginationTrait,InteractionTrait;
    public $group_id = '';
    public $customer_id = '';
    public $results;
    
    public $create_new_interaction = false;
    
    public function mount()
    {
        $this->preparationDatas();
    }
    public function preparationDatas()
    {
        $search = $this->search;
        $current_page = $this->current_page;
        $per_page = $this->per_page;
        $results = $this->paginateInteractions($this->customer_id,$this->group_id,$search,$current_page,$per_page);
        $this->results = $results->items();
        $this->setPaginationAttribute($results);
    }
    public function changedStatus()
    {
        $this->preparationDatas();
    }
    public function render()
    {
        return view('livewire.interactiongroup.interaction.index');
    }
}
