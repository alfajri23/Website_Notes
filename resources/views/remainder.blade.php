@component('mail::message')
# Hallo {{$data['nama']}}
    Kami ingin menginfokan, 
    Deadline untuk Notes :

@component('mail::panel')
    <b> {{$data['judul']}} </b>
    {{$data['desc']}}
@endcomponent

    Tinggal hari ini {{$data['deadline']}}
    Segera selesaikan ya 

@component('mail::button', ['url' => $data['link']])
Lihat Task
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent