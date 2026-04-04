<?php

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'sandbox.smtp.mailtrap.io';
$config['smtp_port'] = 2525;
$config['smtp_user'] = getenv('SMTP_USER');
$config['smtp_pass'] = getenv('SMTP_PASSWORD');
$config['mailtype'] = 'text';
$config['charset'] = 'utf-8';
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";