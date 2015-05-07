<!-- Success-Messages -->
@if ($success = Session::get('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	{{{ $success }}}
</div>
@endif

<!-- Fail-Messages -->
@if ($fail = Session::get('fail'))
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	{{{ $fail }}}
</div>
@endif

@if ($fail = Session::get('danger'))
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	{{{ $fail }}}
</div>
@endif

<!-- Validation-Messages -->
@foreach ($errors->all() as $error)
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	{{{ $error }}}
	
</div>
@endforeach
