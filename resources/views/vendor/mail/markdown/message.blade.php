@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.title') }}
@endcomponent
@endslot

{{-- Body --}}
#Подтвердите вашу учетную запись!
Уважаемый(ая) {{$username}}, проект {{config('app.name_prj')}} благодарит Вас за регистрацию! 
Мы рады, что Вы присоединились к нам, и надеемся, что Вам тут понравится.
@component('mail::button', ['url' => route('register.verify', ['email' => $email, 'verify_token' => $token])])
Подтвердить учетную запись
@endcomponent

{{-- Subcopy --}}
@slot('subcopy')
@component('mail::subcopy')             		
Если у вас возникли проблемы с нажатием на кнопку, скопируйте и вставьте URL-адрес, указанный ниже, в веб-браузер.
{{route('register.verify', ['email' => $email, 'verify_token' => $token])}}	
@endcomponent
@endslot

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name_prj') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
