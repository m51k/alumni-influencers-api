<?php

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'sandbox.smtp.mailtrap.io';
$config['smtp_port'] = 2525;
$config['smtp_user'] = $_ENV['SMTP_USER'];
$config['smtp_pass'] = $_ENV['SMTP_PASS'];
$config['mailtype'] = 'text';
$config['charset'] = 'utf-8';
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";