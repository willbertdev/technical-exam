@component('mail::message')
# Welcome

Thank you for sign up!

@component('mail::button', ['url' => 'http://127.0.0.1:8000/api/verify/' . $remember_token])
Verify
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
