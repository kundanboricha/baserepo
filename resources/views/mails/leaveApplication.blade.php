<x-mail::message>
# Received a Leave Request Application
## Greetings {{$mailData['approverName']}},

This is an automated notification to inform you that **{{$mailData['employeeName']}}** has submitted a leave request for the period of {{$mailData['startDate']}} to {{$mailData['endDate']}}.<br> 
<strong>Reason for Leave is as Below:</strong>
<x-mail::panel>
{{$mailData['leaveDetail']->reason}}
</x-mail::panel>


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
