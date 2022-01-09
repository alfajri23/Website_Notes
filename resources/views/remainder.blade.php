@component('mail::message')
# Hallo {{$user["name"]}}
    Kami ingin menginfokan, 
    Deadline untuk Task Anda :

@component('mail::table')
|Task|Deskripsi|
|-------|:--------|
	@foreach($data as $reminder)
|{{$reminder['judul']}}|{{$reminder['desc']}}
	@endforeach
@endcomponent

Tinggal hari ini
Segera selesaikan ya


Thanks,<br>
{{ config('app.name') }}
@endcomponent