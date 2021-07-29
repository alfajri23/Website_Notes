<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RemainNotify;


class SendNotify extends Controller
{
    public function kirim()
    {
        $email = 'emailtujuan@hotmail.com';
        $data = [
            'name' => 'User',
            'title' => 'Selamat datang!',
            'url' => 'https://aantamim.id',
        ];
        Mail::to($email)->send(new RemainNotify($data));
        return 'Berhasil mengirim email!';
    }
}
