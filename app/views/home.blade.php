@extends('template.skeleton')

@section('title')
{{ _('Home') }}
@stop

@section('content')
	<div class="container">
		<h1>{{ _('Home') }}</h1>
		@include('template.messages')

		@if(Cookie::get('domain_hash'))
		{{ $homepage }}
		@else
		<div class="well">
			<p>Terima kasih telah mengunjungi website kami.</p>
			
			<p>Saat ini kami masih dalam persiapan rilis. Pengembangan dan perbaikan masih terus dilakukan. Anda dapat mengikuti perkembangannya <a href="http://s.id/bagitugasteleponrakyat" target="_blank">disini</a>.</p>
			
			<p>Kendati demikian, layanan pada website ini sudah berjalan dengan cukup baik. Apabila ada kekurangan atau kesalahan biasanya tidak lama kemudian langsung diperbaiki.</p>
			
			<p>Oleh karena ini besar harapan kami agar anda dapat ikut berpartisipasi. Daftarkanlah diri anda sebagai Manager dan tambahkan Domain anda.</p>
			
			<p>Baca petunjuk untuk memulai <a href="http://s.id/memulaiteleponrakyat" target="_blank">disini</a>.</p>
			
			<p>Apabila ditemui kesulitan atau ingin berdiskusi dengan kami maka sila hubungi kami dengan bergabung di Facebook Group kami <a href="https://www.facebook.com/groups/voipid/" target="_blank">disini</a>.</p>
		</div>
		@endif
	</div>	
@stop
