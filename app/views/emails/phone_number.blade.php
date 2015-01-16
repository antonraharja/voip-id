<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>New phone number</h2>

		<div>
			{{ _('Phone Number : ').$phone_number_e164 }}
			<br>
			{{ _('SIP Username : ').$local_phone_number }}
			<br>
			{{ _('SIP Password : ').$sip_password }}
			<br>
			{{ _('SIP Domain : ').$domain_control_panel }}
			<br>
			{{ _('SIP Server : ').$domain_sip_server }}
		</div>
	</body>
</html>