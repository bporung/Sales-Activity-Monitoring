<?php

namespace App\Http\Livewire\Component\Websocket;

use Livewire\Component;
use App\Models\NotificationReader;
use Auth;

class Notificationbadge extends Component
{
    public $countresults = 0;


    public function getListeners()
    {
        return [
            "echo:notification,NotificationUpdated" => 'notificationUpdated',
        ];
    }
    public function mount(){
        $this->preparationDatas();
    }
    public function notificationUpdated(){
        $this->preparationDatas();
    }
    public function preparationDatas(){
        $user = Auth::user();
        $results = NotificationReader::orderBy('created_at','DESC')->where('is_read','0')->where('user_id',$user->id)->count();
        $this->countresults = $results;
    }
    public function render()
    {
        return view('livewire.component.websocket.notificationbadge');
    }
}
