<?php

function getHeaders()
{
	return 'From: info@najafi.org' . "\r\n" .
		'Reply-To: no-reply@najafi.org' . "\r\n" .
		'Content-type: text/html; charset=iso-8859-1' . "\r\n".
		'X-Mailer: PHP/' . phpversion();
}
