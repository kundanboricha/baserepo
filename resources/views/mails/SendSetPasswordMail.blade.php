<x-mail::message>
# Hello {{ $mailData['user']->name }},
## You Have Received this Mail Because Your Account Has Been Created In Our Employee Management System.

Please click the button below to set your password.

<x-mail::button :url="$mailData['url']">
Proceed
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
