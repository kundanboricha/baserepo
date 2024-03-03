<x-mail::message>
# Company Registration to Employee Management System

## Hello {{ $mailData['name'] }} ,
Your Company {{ $mailData['company'] }} has been registed in our System , Please Set a Password to Secure Your
Account.

<x-mail::button :url="$mailData['route']">
Set Password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}    
</x-mail::message>
