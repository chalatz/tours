<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

$smtp_key = include '_smtp_key.php';

$mail->isSMTP();
$mail->Host = 'mail.rhodesprivatetours.com';
$mail->SMTPAuth = true;
$mail->Username = 'smtp@rhodesprivatetours.com';
$mail->Password = $smtp_key;
//$mail->SMTPSecure = 'tls';
$mail->Port = 25;

$debug = true;

if ($debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

include_once 'geo.php';

$return_to = '';
$from_page = '';
$first_name = '';
$last_name = '';
$reservation_name = '';
$city_state_zip = '';
$phone_fax = '';
$e_mail = '';
$date11_month = '';
$date11_date = '';
$date11_year = '';
$ship_flight_num = '';
$type_of_tour = '';
$speaking_language = '';
$party_num = '';
$comments = '';
$ipAddress = $api_result['query'];
$countryCode = $api_result['countryCode'];
$countryName = $api_result['country'];
$regionName = $api_result['region'];
$cityName = $api_result['city'];
$zipCode = $api_result['zip'];

$return_to = $_POST['return_to'];
$from_page = $_POST['from_page'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$reservation_name = $_POST['reservation_name'];
$city_state_zip = $_POST['city_state_zip'];
$phone_fax = $_POST['phone_fax'];
$e_mail = $_POST['e_mail'];
$date11_month = $_POST['date11_month'];
$date11_date = $_POST['date11_date'];
$date11_year = $_POST['date11_year'];
$ship_flight_num = $_POST['ship_flight_num'];
$type_of_tour = $_POST['type_of_tour'];
$speaking_language = $_POST['speaking_language'];
$party_num = $_POST['party_num'];
$comments = $_POST['comments'];

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

$e_subject = 'New request from ' . $e_mail . '.';

$msg = "Details:\r\n\n";

$msg .= "From: $from_page\r\n";
if($type_of_tour != ''){
    $msg .= "Type of Tour: $type_of_tour\r\n";
}
$msg .= "First Name: $first_name\r\n";
$msg .= "Last Name: $last_name\r\n";
$msg .= "Services to be reserved in the name(s): $reservation_name\r\n";
$msg .= "City/State/Country: $city_state_zip\r\n";
$msg .= "Phone/Fax: $phone_fax\r\n";
$msg .= "E-mail: $e_mail\r\n";
$msg .= "Private Tour Date: $date11_month - $date11_date - $date11_year\r\n";
$msg .= "Private Tour Start Location Hotel / Cruise Ship / Flight Number: $ship_flight_num\r\n";
$msg .= "Language: $speaking_language\r\n";
$msg .= "Number in party: $party_num\r\n";
$msg .= "Comments:\r\n $comments\r\n";

$msg .= "Ip Address: $ipAddress\r\n";
$msg .= "Country Code: $countryCode\r\n";
$msg .= "Country Name: $countryName\r\n";
$msg .= "Region Name: $regionName\r\n";
$msg .= "City Name: $cityName\r\n";
$msg .= "Zip Code: $zipCode\r\n";

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
    //die();
}

$headers = "Content-Type: text/html; charset=UTF-8";

// include_once('_keys.php');

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

$address = "smtp@rhodesprivatetours.com";
$from_address = "smtp@rhodesprivatetours.com";

$mail->Sender= $address;
$mail->SetFrom($e_mail, $e_mail, FALSE);

$mail->addReplyTo($e_mail, $e_mail);

$mail->addAddress($address);

$mail->isHTML(false);
$mail->Subject = $e_subject;
$mail->Body = $msg;

if(passed_recaptcha() && $mail->send()){
    // Email has sent successfully, echo a success page.

    //header('Location: ' . $return_to . '?contact-form-sent=success');
	echo 'Message sent!';

} else {
    //header('Location: '. $return_to . '?contact-form-sent=fail');
	echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}

?>