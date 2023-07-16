<?php

namespace App\Http\Traits\Component\Pagination;

trait PaginationTrait {

    public $current_page = 1;
    public $last_page = 1;
    public $total = 0;
    public $start_data_page = 0;
    public $end_data_page = 0;
    public $per_page = 10;
    public $search = '';
    public $advSearch = [];
    public $readstatus = [
        'is_read' => true,
        'is_not_read' => true,
    ];
    public $created_date = [
        'start' => '',
        'end' => '',
    ];

    protected function getListeners()
    {
        return [
            'updated-search' => 'updateSearch',
            'exported-excel' => 'exportExcel',
            'exported-pdf' => 'exportPDF',
            'updated-readstatus' => 'updateReadstatus',
            'updated-created_date' => 'updateCreatedDate',
            'updated-advanced-search' => 'updateAdvSearch',
        ];
    }

    public function setPaginationAttribute($results){
        $this->last_page = $results->lastPage();
        $this->total = $results->total();
        $this->per_page = $results->perPage();


        $this->start_data_page = 0;
        $this->end_data_page = 0;

        if($this->current_page <= $this->last_page){
            if($this->current_page < 2){
                $this->start_data_page = 1;
            }else{
                $this->start_data_page = (($this->current_page - 1) * $this->per_page) + 1;
            }

            if($this->current_page ==  $this->last_page){
                if($this->total % $this->per_page){
                    $this->end_data_page = (($this->current_page - 1) * $this->per_page) + ($this->total % $this->per_page);
                }else{
                    $this->end_data_page = (($this->current_page - 1) * $this->per_page) + ($this->per_page);
                }
            }else{
                $this->end_data_page = ($this->current_page * $this->per_page);
            }
        }
    }

    public function updateSearch($val){
        $this->search = $val;
        $this->current_page = 1;
        $this->preparationDatas();
    }
    public function updateAdvSearch($val){
        $this->advSearch = $val;
        $this->current_page = 1;
        $this->preparationDatas();
    }
    public function updateReadstatus($val){
        $this->readstatus = $val;
        $this->preparationDatas();
    }
    public function updateCreatedDate($val){
        $this->created_date = $val;
        $this->preparationDatas();
    }
    public function exportExcel(){
        $this->exportDatas('excel');
    }
    public function exportPDF(){
        $this->exportDatas('pdf');
    }
    public function updatedCurrentPage(){
        $this->preparationDatas();
    }
    public function runNextPage(){
        if($this->current_page < $this->last_page){
            $this->current_page = $this->current_page + 1;
        }
        $this->preparationDatas();
    }
    public function runPreviousPage(){
        if($this->current_page > 1){
            $this->current_page = $this->current_page - 1;
        }
        $this->preparationDatas();
    }
    public function runFirstPage(){
        if($this->current_page > 1){
            $this->current_page = 1;
        }
        $this->preparationDatas();
        
    }
    public function runLastPage(){
        if($this->current_page < $this->last_page){
            $this->current_page = $this->last_page;
        }
        $this->preparationDatas();
    }
}