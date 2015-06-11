<?php 
$length = count($online_phone);
$i =1;
?>
[
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