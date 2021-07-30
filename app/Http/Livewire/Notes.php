<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Note;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\Auth;
use Livewire\WithPagination; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RemainNotify;

class Notes extends Template
{

    public function mount(){
        $now = Carbon::today();
        $note = Note::where('user_id', auth()->user()->id)->orderBy('deadline','asc')->get();
        foreach ($note as $notes) {
            $Date = date('Y-m-d');
            //$notes->deadline = $notes->deadline - $Date;
            if($notes->status=='done'){   
            }
            else{
                if($notes->deadline>$Date){
                    $this->update_status($notes->id,"pending");
                    // $day =  $notes->deadline;

                    // $newDate = Carbon::parse($day)->format('Y-m-d'); 
                    // $newdate = Carbon::createFromFormat('Y-m-d', $day)->format('Y-m-d');

                    // var_dump($newDate);
                    // $length = $newdate->diffInDays($now);                  
                    // $this->update_countdown($notes->id,$length);
                }
                else if($notes->deadline<$Date){
                    $this->update_status($notes->id,"passed");  
                }
                else if($notes->deadline == $Date){
                    $data = [
                        'nama' => auth()->user()->name,
                        'judul' => $notes->judul,
                        'desc' => $notes->desc,
                        'deadline' => $notes->deadline,
                        'link' => 'http://noteside.herokuapp.com'
                    ];

                    Mail::to(auth()->user()->email)->send(new RemainNotify($data));
                }
            }                        
        }
    }

    public function render(){  
        
        $note=null;
        
        $date = date('Y-m-d');
        //jika tidak ada search
        if($this->search === null){
            if($this->filter == 'pending'){   //urut judul
                $note = Note::where('user_id', auth()->user()->id)->where('status','pending')->orderBy('deadline','asc')->paginate($this->paginate);
            }
            else if($this->filter == 'done'){    //urut tanggal
                $note = Note::where('user_id', auth()->user()->id)->where('status','done')->orderBy('deadline','asc')->paginate($this->paginate);
            }
            else if($this->filter == 'passed'){    //urut tanggal
                $note = Note::where('user_id', auth()->user()->id)->where('status','passed')->orderBy('deadline','asc')->paginate($this->paginate);
            }
            else if($this->filter == 'date_now'){  //tanggal hari ini
                $note = Note::where('user_id', auth()->user()->id)->where('deadline','like','%'. $date.'%')->paginate($this->paginate);
            }
            else{                                   //tampil semua
                $note = Note::where('user_id', auth()->user()->id)->orderBy('deadline','asc')->paginate($this->paginate);
            } 

        //jika ada keyword search
        }else{
            $note = Note::where('user_id', auth()->user()->id)
                    ->where('judul','like','%'. $this->search.'%')->paginate($this->paginate);
            
        }

        //get list team
        $team = Team::whereIn('id',TeamUser::select('team_id')->where('user_id', auth()->user()->id )->get())->get();

        //date left
        $now = Carbon::tomorrow();
        $length = $now -> diffInDays($date);
        //dd($note);

        return view('livewire.notes',[
            'note'=>$note,
            'date'=>$this->filter,
            'team'=>$team
        ]);

        $this->filter = null;
        $this->search = null;
    }

}
