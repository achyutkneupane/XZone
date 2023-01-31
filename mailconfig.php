<?php
require $_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/SMTP.php';

date_default_timezone_set('Asia/Kathmandu');
$mail = new PHPMailer\PHPMailer\PHPMailer();;
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = 'YOUR HOST';
$mail->Port = 465;

$mail->Username = 'YOUR EMAIL/USERNAME';
$mail->Password = 'YOUR PASSOWORD';

$mail->setFrom('YOUR EMAIL', 'YOUR NAME');
?>