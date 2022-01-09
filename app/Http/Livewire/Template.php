<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Note;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\Auth;
use Livewire\WithPagination; 
use Carbon\Carbon;

class Template extends Component
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

    public function date_left(){

    }

    public function store(){
        // $this->validate([
        //     'judul' => 'required|string',
        //     'deadline' => 'require',
        //     'user_id' => 'require',
        // ]);
        //dd("hallo");

        Note::updateOrCreate(['id' => $this->id_note],[
            //menambahkan unik id karena heroku tdk bisa increment id
            'id' => rand(),
            'status' => 'pending',
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

    public function update_countdown($id,$value){
        $note = Note::find($id);
        $note->day_left= $value;
        $note->save();
    }

    public function count_date($date){
        //date left
        
        $now = Carbon::today();
        dd($now);
        //$length = $date -> diffInDays($now);
        return $length;
        //dd($note);
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