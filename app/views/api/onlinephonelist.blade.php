<?php 
$length = count($online_phone);
$i =1;
?>
{
"error_code": {{ $error[0] }},
"error_string": "{{ $error[1] }}",
"response_data":[
@foreach ($online_phone as $online_phones)
           {
           "phone":"{{$online_phones->domain->prefix}}-{{$online_phones->username}}",
           "user_id":"{{$online_phones->username}}",
           "dss":"{{$online_phones->sip_server }}",
           "description":"{{$online_phones->phonenumber->description}}"
           }
           @if ($i < $length)
           ,
           @endif
           <?php
           $i++;
           ?>
@endforeach
]
}