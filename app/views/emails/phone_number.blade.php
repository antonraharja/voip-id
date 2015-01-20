<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>New phone number</h2>

		<div>
			{{ _('E164 Phone Number').' : '.$phone_number_e164 }}
			<br>
			<br>
			
			{{ _('Phone Number or SIP Username').' : '.$local_phone_number }}
			<br>
			{{ _('SIP Password').' : '.$sip_password }}
			<br>
			{{ _('SIP Domain').' : '.$domain_sip_server }}
			<br>
			{{ _('SIP Server').' : '.$domain_sip_server }}
			<br>
			<br>
			
			{{ _('Control Panel').' : http://'.$domain_control_panel }}
			<br>
		</div>
	</body>
</html>
