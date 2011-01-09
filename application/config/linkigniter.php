<?php
/*
|--------------------------------------------------------------------------
| CSRF Protection system
|--------------------------------------------------------------------------
|
| Set to TRUE to enable an automatic csrf protection system on the site.
| It will automatically generate protection tokens and inject them
| on POST forms on your views.
|
| For ajax POST calls you will have to send the token yourself. You can 
| get it's contents from $this->session->userdata('li_token'), and it
| must be with parameter name "li_token". You can also obtain that data 
| from the meta-headers called "csrf-name" and "csrf-token" for ajax calls.
|
*/
$config['linkigniter.enable_csrf_protection'] = TRUE;