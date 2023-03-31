<?php

require_once "../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Noodlehaus\config;
use Noodlehaus\Parser\Json;
use Tracy\Debugger;
$config = Config::load('config.json');


$mail = new PHPMailer();
try {


    $mail->Subject = "Cus bbuznuss";
    $mail->isHTML(true);
    $mail->Body = "<h1>Toto je mail ty majsicko pro ne tebe</h1> <p>Jdi doprdele koomorniku <strong>nepadej</strong></p>";
    $mail->AltBody = "KOmornik spadl jo dobry ekk ejejr somr v pesawre";

    $mail->addAddress("luky.rolenec@seznam.cz");
    $mail->addAddress("luky.rolenec@seznam.cz");
    $mail->addAddress("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->addCC("benes.dan.cz@seznam.cz");
    $mail->setFrom("lukyrolenec@gmail.com");
    $mail->addReplyTo("luky.rolenec@seznam.cz");

    $mail->isSMTP(true);
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "lukyrolenec@gmail.com";
    $mail->Password = "apbacifdmoxtdhma";
    $mail->Port = "465";

    $mail->CharSet = "UTF-8";
    $mail->Encoding = PHPMailer::ENCODING_BASE64;
    $mail->Encoding = PHPMailer::ENCODING_QUOTED_PRINTABLE;

    $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;

    $mail->send();
}catch (Exception $exception){
    var_dump("error");
}