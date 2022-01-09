<?php

namespace App\Services\Note;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteService
{
    public static function get_all()
    {
        $model = Note::latest()->get();

        return $model;
    }

    public static function get_today()
    {
        $model = Note::where('deadline',now()->format('Y-m-d'))->get();

        return $model;
    }

    
}
