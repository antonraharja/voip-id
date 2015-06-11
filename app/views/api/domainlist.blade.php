<?php 
$length = count($domain_list);
$i =1;
?>
[
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