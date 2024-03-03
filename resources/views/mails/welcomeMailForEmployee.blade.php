<x-mail::message>
# Employee Registration to Employee Management System

## Hello {{ $mailData['name'] }} ,
You have been Added as an Employee by {{$mailData['auth']}} , Please Set a Password to Secure Your
Account.

<x-mail::button :url="$mailData['route']">
Set Password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}    
</x-mail::message>
