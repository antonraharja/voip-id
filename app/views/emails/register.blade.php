<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>New user registration</h2>

		<div>
			Welcome {{ $new_user }}. Login from {{ URL::to('login') }}.
		</div>
	</body>
</html>