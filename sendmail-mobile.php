<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer();

$smtp_key = include '_smtp_key.php';

$mail->isSMTP();
$mail->Host = 'mail.rhodesprivatetours.com';
$mail->SMTPAuth = true;
$mail->Username = 'smtp@rhodesprivatetours.com';
$mail->Password = $smtp_key;
//$mail->SMTPSecure = 'tls';
$mail->Port = 25;

$debug = false;

if ($debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

include_once 'geo.php';

$return_to = '';
$from_page = '';
$page_url = '';
$first_name = '';
$e_mail = '';
$comments = '';

$ipAddress = $api_result['query'];
$countryCode = $api_result['countryCode'];
$countryName = $api_result['country'];
$regionName = $api_result['region'];
$cityName = $api_result['city'];
$zipCode = $api_result['zip'];

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$return_to = test_input($_POST['return_to']);
$from_page = test_input($_POST['from_page']);
$page_url = test_input($_POST['page_url']);
$first_name = test_input($_POST['first_name']);
$e_mail = test_input($_POST['e_mail']);
$comments = test_input($_POST['comments']);

$e_subject = 'New request from ' . $e_mail . '.';

$msg = "Details:\r\n\n";

$msg .= "-- Mobile Form --\r\n";
$msg .= "From: $from_page\r\n";
$msg .= "Page URL: $page_url\r\n";
$msg .= "Name: $first_name\r\n";
$msg .= "E-mail: $e_mail\r\n";
$msg .= "Comments:\r\n $comments\r\n";

$msg .= "Ip Address: $ipAddress\r\n";
$msg .= "Country Code: $countryCode\r\n";
$msg .= "Country Name: $countryName\r\n";
$msg .= "Region Name: $regionName\r\n";
$msg .= "City Name: $cityName\r\n";
$msg .= "Zip Code: $zipCode\r\n";

function passed(){
    // if(isset($_POST['meli_tria'])){
    //     $meli_tria_passed = false;
    // } else {
    //     $meli_tria_passed = true;
    // }
    // if ($_POST['meli_ena'] == '' && $_POST['meli_dio'] == '' && $meli_tria_passed){
    //     return true;
    // } else {
    //     return false;
    // }

    if(isset($_POST['meli_tria'])){
        $meli_tria_passed = false;
    } else {
        $meli_tria_passed = true;
    }
    if ($_POST['meli_dio'] == '' && $meli_tria_passed){
        return true;
    } else {
        return false;
    }
}

if ($debug) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    if (passed()) {
        echo 'passed!<br>';
    } else {
        echo 'failed!<br>';
    }
    print_r($msg);
    die();
}

function validated() {
    if(isset($_POST['first_name']) && $_POST['first_name'] == ''){
        return false;
    }
    if(isset($_POST['e_mail']) && $_POST['e_mail'] == ''){
        return false;
    }
    if(isset($_POST['comments']) && $_POST['comments'] == ''){
        return false;
    }

    return true;
}

function passed_recaptcha(){

    if (passed()) {
        $url = 'https://www.google.com/recaptcha/api/siteverify';

        $key = include '_recaptcha_key.php';

        $response = file_get_contents($url."?secret=".$key."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);

        $data = json_decode($response);

        if(isset($data->success) && $data->success == true){
            return true;
        } else {
            return false;
        }

    }
}

$address = "request@rhodesprivatetours.com";
$from_address = "smtp@rhodesprivatetours.com";

$mail->Sender= $from_address;
$mail->SetFrom($e_mail, $e_mail, FALSE);

$mail->addAddress($address);
$mail->addReplyTo($e_mail, $e_mail);

$mail->isHTML(false);
$mail->Subject = $e_subject;
$mail->Body = $msg;

if(validated()) {
    if(passed_recaptcha() && $mail->send())
    {
        // Email has sent successfully, echo a success page.

        header('Location: ' . $return_to . '?contact-form-sent=success');

    } else {
        header('Location: '. $return_to . '?contact-form-sent=fail');
    }
} else {
    header('Location: '. $return_to . '?contact-form-sent=validation-error');
}


?>