<?php

namespace App\Http\Livewire\Master\Customer\Interactiongroup;

use Livewire\Component;
use App\Http\Traits\Component\Pagination\PaginationTrait;
use App\Http\Traits\InteractionGroupTrait;

class Index extends Component
{
    use PaginationTrait,InteractionGroupTrait;
    public $customer_id = '';
    public $results;
    public $isActive = TRUE;
    public $notActive = FALSE;
    
    public function mount()
    {
        $this->preparationDatas();
    }
    public function preparationDatas()
    {
        $isActive = $this->isActive;
        $notActive = $this->notActive;
        $search = $this->search;
        $current_page = $this->current_page;
        $per_page = $this->per_page;
        $results = $this->paginateInteractionGroups($this->customer_id,$search,$isActive,$notActive,$current_page,$per_page);
        $this->results = $results->items();
        $this->setPaginationAttribute($results);
    }
    public function changedStatus()
    {
        $this->preparationDatas();
    }

    public function render()
    {
        return view('livewire.master.customer.interactiongroup.index');
    }
}
