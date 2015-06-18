<?php 
$length = count($phone_numbers);
$i =1;
?>
{
"error_code": {{ $error[0] }},
"error_string": "{{ $error[1] }}",
"response_data":[
@foreach ($phone_numbers as $phone_number)
           {
           "owner":"{{ $phone_number->user->username }}",
           "e164":"{{ $phone_number->user->domain->prefix }}-{{ $phone_number->extension }}",
           "local_phone_number":"{{ $phone_number->extension }}",
           "description":"{{ $phone_number->description }}"
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