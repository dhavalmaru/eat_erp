<?php
$to      = 'dhaval.maru@otbconsulting.co.in';
$subject = 'Test';
$message = 'hello';
$headers = 'From: webmaster@eatanytime.in' . "\r\n" .
    'Reply-To: webmaster@eatanytime.in' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?> 