{{ _('SIP Username : ').$phone_number->extension }}
<br>
{{ _('SIP Password : ******') }}
<br>
{{ _('SIP Domain : ').Domain::find(Cookie::get('domain_hash'))->domain }}
<br>
{{ _('SIP Server : ').Config::get('settings.sip_server') }}