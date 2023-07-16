<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;
use App\Models\NotificationReader;
use Auth;
use App\Http\Traits\Component\Pagination\PaginationTrait;
use App\Events\NotificationUpdated;
class Index extends Component
{
    use PaginationTrait;
    public $results;
    public $pagination;

    
    public function mount(){
        $this->preparationDatas();
    }
    public function preparationDatas() {
        $results = $this->getDatas();
        $this->results = $results->items();
        $this->setPaginationAttribute($results);
    }
    public function getDatas() {
        $readstatus = $this->readstatus;
        $user = Auth::user();
        $search = $this->search;
        $current_page = $this->current_page;
        $per_page = $this->per_page;

        $results = NotificationReader::orderBy('created_at','DESC')->where('user_id',$user->id);
        
        if($readstatus){
            if($readstatus['is_read'] && !$readstatus['is_not_read']){$results = $results->where('is_read','1');}
            if(!$readstatus['is_read'] && $readstatus['is_not_read']){$results = $results->where('is_read','0');}
        }
        if($search){
            $results = $results->whereHas('notification',function($q) use($search){
                $q->where('subject','LIKE','%'.$search.'%')->orWhere('description','LIKE','%'.$search.'%');
            });
        }
        $results = $results->paginate($per_page, ['*'], 'page', $current_page);

        return $results;
    }
    public function markAsRead($id){
        $markAsRead = NotificationReader::findOrFail($id)->update([
            'is_read' => '1'
        ]);
        $this->preparationDatas();
        event(new NotificationUpdated);
    }
    public function render()
    {
        return view('livewire.notification.index',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'Notification' , 'link' => '/notification'],
            ],
        'navigationTab' => [
            ['title' => 'Data' , 'link' => '' , 'status' => '1'],
        ]
        ]);
    }
}
