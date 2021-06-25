<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Note;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\Auth;

class TeamNotes extends Component
{

    public $post;
    public $search;
    public $filter;
    public $edit = false;
    public $show;

    public function mount($id)
    {
        $this->post = $id;
    }

    public function render()
    {
        //dd($this->post);
        $team = Team::whereIn('id',TeamUser::select('team_id')->where('user_id', auth()->user()->id )->get())->get();
        $note = Note::where('team_id',$this->post)->get();
        

        return view('livewire.team-notes',[
            'post'=>$this->post,
            'team'=>$team,
            'note'=>$note
        ]);
    }

   
}
