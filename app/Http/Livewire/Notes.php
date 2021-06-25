<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Note;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\Auth;
use Livewire\WithPagination; 

class Notes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $judul,$desc,$deadline;
    public $id_note;
    public $paginate = 10;
    public $search;
    public $filter;
    public $edit = false;
    public $show;

    public function render(){  

        $note=null;
        $nama="feri";

        
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

        $team = Team::whereIn('id',TeamUser::select('team_id')->where('user_id', auth()->user()->id )->get())->get();

        return view('livewire.notes',[
            'note'=>$note,
            'date'=>$this->filter,
            'team'=>$team
        ]);

        $this->filter = null;
    }

    public function store(){
        // $this->validate([
        //     'judul' => 'required|string',
        //     'deadline' => 'require',
        //     'user_id' => 'require',
        // ]);

        Note::updateOrCreate(['id' => $this->id_note],[
            'judul' => $this->judul,
            'desc' => $this->desc,
            'deadline' => $this->deadline,
            'user_id' => auth()->user()->id,
        ]);

        $this->judul='';
        $this->desc='';
        $this->deadline='';
        $this->id_note=null;
    }

    public function update_status($id,$value){
        $note = Note::find($id);
        $note->status= $value;
        $note->save();
    }

    public function edit($id){
        $this->edit=true;
        $note= Note::find($id);
        $this->judul = $note->judul;
        $this->desc = $note->desc;
        $this->deadline = $note->deadline;
        $this->id_note = $note->id;
    }

    public function cancel_edit(){
        $this->judul='';
        $this->desc='';
        $this->deadline='';
        $this->id_note=null;
        $this->edit=false;
    }

    public function delete($id){
        $note = Note::find($id); 
        $note->delete(); 
        session()->flash('message', $note->name . ' Dihapus'); 
    }

    //filter status
    public function mount(){
        $note = Note::where('user_id', auth()->user()->id)->paginate($this->paginate);
        foreach ($note as $notes) {
            $Date = date('Y-m-d');
            //$notes->deadline = $notes->deadline - $Date;
           
            if($notes->status=='done'){   
            }
            else{
                if($notes->deadline>$Date){
                    $this->update_status($notes->id,"pending"); 
                }
                else if($notes->deadline<$Date){
                    $this->update_status($notes->id,"passed");  
                }
            }                        
        }
    }

    public function show_all(){
        $this->filter=null;
    }

    public function filter_now_date(){
        $this->filter='date_now';
    }

    public function filter_pending(){
        $this->filter='pending';
    }

    public function filter_done(){
        $this->filter='done';
    }

    public function filter_passed(){
        $this->filter='passed';
    }

    public function add_role(){
        auth()->user()->assignRole('user');
    }

    public function del_role(){
        auth()->user()->removeRole('user');
    }

}
