<?php 
$length = count($users);
$i =1;
?>
[
@foreach ($users as $user)
           {
           "username":"{{ $user->username }}",
           "name":"{{ $user->profile->first_name }} {{ $user->profile->last_name }}",
           "email":"{{ $user->email }}"
           }
           @if ($i < $length)
           ,
           @endif
           <?php
           $i++;
           ?>
@endforeach
]