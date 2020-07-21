@component('mail::message')
# Introduction

The body of your message.
Klik link berikut untuk mengaktifkan akun anda.
<!-- 
@component('mail::button', ['url' => '']) -->
@component('mail::button', ['url' => url('activation/' . $user->activation_token) ]);
Aktifkan!
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
