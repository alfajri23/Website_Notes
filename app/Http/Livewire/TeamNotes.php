<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Note;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\Auth;

class TeamNotes extends Template
{

    public function mount($id)
    {
        $this->post = $id;
    }

    public function render()
    {
        $team = Team::whereIn('id',TeamUser::select('team_id')->where('user_id', auth()->user()->id )->get())->get();
        $note = Note::where('team_id',$this->post)->get();

        $note=null;
        
        $date = date('Y-m-d');
        //jika tidak ada search
        if($this->search === null){
            if($this->filter == 'pending'){   //urut judul
                $note = Note::where('team_id',$this->post)->where('status','pending')->orderBy('deadline','asc')->paginate($this->paginate);
            }
            else if($this->filter == 'done'){    //urut tanggal
                $note = Note::where('team_id',$this->post)->where('status','done')->orderBy('deadline','asc')->paginate($this->paginate);
            }
            else if($this->filter == 'passed'){    //urut tanggal
                $note = Note::where('team_id',$this->post)->where('status','passed')->orderBy('deadline','asc')->paginate($this->paginate);
            }
            else if($this->filter == 'date_now'){  //tanggal hari ini
                $note = Note::where('team_id',$this->post)->where('deadline','like','%'. $date.'%')->paginate($this->paginate);
            }
            else{                                   //tampil semua
                $note = Note::where('team_id',$this->post)->orderBy('deadline','asc')->paginate($this->paginate);
            } 

        //jika ada keyword search
        }else{
            $note = Note::where('team_id',$this->post)
                    ->where('judul','like','%'. $this->search.'%')->paginate($this->paginate);
            $this->search = null;
        }
        

        return view('livewire.team-notes',[
            'post'=>$this->post,
            'team'=>$team,
            'note'=>$note
        ]);
    }

    public function store(){
        // $this->validate([
        //     'judul' => 'required|string',
        //     'deadline' => 'require',
        //     'user_id' => 'require',
        // ]);

        Note::updateOrCreate(['id' => $this->id_note , 'team_id' => $this->post ],[
            'judul' => $this->judul,
            'desc' => $this->desc,
            'deadline' => $this->deadline,
            'user_id' => auth()->user()->id,
            'team_id' => $this->post,
        ]);

        $this->judul='';
        $this->desc='';
        $this->deadline='';
        $this->id_note=null;
    }
}

