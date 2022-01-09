<?php

namespace App\Resources\Note;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'desc' => $this->desc,
            'status' => $this->status,
            'day_left' => $this->day_left,
            'team_id' => $this->team_id,
            'email_user' => empty($this->jenis) ? null : $this->jenis->nama,
        ];
    }
}
