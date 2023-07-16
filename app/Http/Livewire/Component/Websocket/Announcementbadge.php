<?php

namespace App\Http\Livewire\Component\Websocket;

use Livewire\Component;
use App\Models\AnnouncementReader;
use Auth;

class Announcementbadge extends Component
{
    public $countresults = 0;
    public function getListeners()
    {
        return [
            "echo:announcement,AnnouncementUpdated" => 'announcementUpdated',
        ];
    }
    public function mount(){
        $this->preparationDatas();
    }
    public function announcementUpdated(){
        $this->preparationDatas();
    }
    public function preparationDatas(){
        $user = Auth::user();
        $results = AnnouncementReader::orderBy('created_at','DESC')->where('is_read','0')->where('user_id',$user->id)->count();
        $this->countresults = $results;
    }
    public function render()
    {
        return view('livewire.component.websocket.announcementbadge');
    }
}
