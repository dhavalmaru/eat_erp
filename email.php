<?php
$to      = 'dhaval.maru@pecanreams.com';
$subject = 'Test';
$message = 'hello';
$headers = 'From: cs@eatanytime.co.in' . "\r\n" .
    'Reply-To: cs@eatanytime.co.in' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?> 