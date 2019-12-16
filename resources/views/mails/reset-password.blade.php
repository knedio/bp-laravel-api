@component('mail::message')
Dear {{ $params['first_name'] }},

Click the button below to reset your password.

@component('mail::button', ['url' => $params['url'] ])
{{ env('APP_NAME') }}
@endcomponent
@endcomponent