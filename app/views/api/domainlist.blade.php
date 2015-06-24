<?php 
$length = count($domain_list);
$i =1;
?>
{
"error_code": {{ $error[0] }},
"error_string": "{{ $error[1] }}",
"response_data":[
@foreach ($domain_list as $domain)
           {
           "dcp":"{{$domain->domain}}",
           "dss":"{{$domain->sip_server}}",
           "prefix":"{{$domain->email }}",
           "description":"{{$domain->description}}"
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
