<?php
require $_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/SMTP.php';

date_default_timezone_set('Asia/Kathmandu');
$mail = new PHPMailer\PHPMailer\PHPMailer();;
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->Port = 2525;

$mail->Username = '3a433285e4e4c5';
$mail->Password = 'c3bc63153ec68c';

$mail->setFrom('contact@xzone.com', 'XZone');
?>