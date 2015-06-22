<?php 
$length = count($gateways);
$i =1;
?>
{
"error_code": {{ $error[0] }},
"error_string": "{{ $error[1] }}",
"response_data":[
@foreach ($gateways as $gateway)
           {
           @if(Auth::user()->status == 2)
           "owner":"{{ $gateway->user->username }}",
           @endif
           "gateway_name":"{{ $gateway->gateway_name }}",
           "gateway_address":"{{ $gateway->gateway_address }}}",
           "prefix":"+{{ Config::get('settings.global_prefix') }}-{{ $gateway->prefix }}",
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