<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Notification</h2>

		<div>
		    <table border="0">
		    @foreach($data as $key => $val)
		        <tr>
		            <td valign="top" width="150">{{ ucfirst(str_replace("_"," ",$key)) }}</td><td valign="top" width="10">:</td>
		            <td valign="top">
		                @if(is_array($val))
		                    @foreach($val as $k => $v)
		                         - {{ $k }} : {{ $v }}<br>
		                    @endforeach
		                @else
		                {{ $val }}
		                @endif
		            </td>
		        </tr>
		    @endforeach
		    </table>
		</div>
	</body>
</html>