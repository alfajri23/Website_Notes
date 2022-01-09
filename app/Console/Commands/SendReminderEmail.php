<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RemainNotify;

use App\Services\Note\NoteService;

class SendReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $note = Note::where('deadline',now()->format('Y-m-d'))->get();

        $data = [];

        foreach ($note as $noted) {
            $data[$noted->user_id][] = $noted->toArray();
        }


        foreach ($data as $userId => $reminders) {
            $this->sendEmailToUser($userId, $reminders);
        }
    }

    private function sendEmailToUser($userId, $reminders)
    {
        $user = User::find($userId);
        //dd($user["email"]);

        Mail::to($user->email)->send(new RemainNotify($reminders,$user));
    }
}
