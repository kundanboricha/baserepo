<x-mail::message>
# Response to your Leave Request Application.

This is an automated notification to inform you that your Leave Request has been {{$mailData['status']}}. 

<x-mail::panel>
Status: {{$mailData['status']}}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
