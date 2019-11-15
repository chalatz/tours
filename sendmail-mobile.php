<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'class.IPInfoDB.php';

$ipinfodb = new IPInfoDB('043542783908f8d1b64ecfbd312ee672570dabad52c780a3c52ad643c6a29f7b');
$results = $ipinfodb->getCity($_SERVER['REMOTE_ADDR']);

$return_to = '';
$from_page = '';
$page_url = '';
$first_name = '';
$city_state_zip = '';
$e_mail = '';
$comments = '';

$ipAddress = $results['ipAddress'];
$countryCode = $results['countryCode'];
$countryName = $results['countryName'];
$regionName = $results['regionName'];
$cityName = $results['cityName'];
$zipCode = $results['zipCode'];
$timeZone = $results['timeZone'];

$return_to = $_POST['return_to'];
$from_page = $_POST['from_page'];
$page_url = $_POST['page_url'];
$first_name = $_POST['first_name'];
$city_state_zip = $_POST['city_state_zip'];
$e_mail = $_POST['e_mail'];
$comments = $_POST['comments'];

$address = "request@rhodesprivatetours.com";

$e_subject = 'New request from ' . $e_mail . '.';

$msg = "Details:\r\n\n";

$msg .= "<b>-- Mobile Form --</b>\r\n";
$msg .= "From: <b>$from_page</b>\r\n";
$msg .= "Page URL: $page_url\r\n";
$msg .= "Name: $first_name\r\n";
$msg .= "City/State/Country: $city_state_zip\r\n";
$msg .= "E-mail: $e_mail\r\n";
$msg .= "Comments:\r\n $comments\r\n";

$msg .= "Ip Address: $ipAddress\r\n";
$msg .= "Country Code: $countryCode\r\n";
$msg .= "Country Name: $countryName\r\n";
$msg .= "Region Name: $regionName\r\n";
$msg .= "City Name: $cityName\r\n";
$msg .= "Zip Code: $zipCode\r\n";
$msg .= "Time Zone: $timeZone\r\n";

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

    return true;
}

if(passed() && mail($address, $e_subject, $msg, "From: $e_mail\r\nReply-To: $e_mail\r\nReturn-Path: $e_mail\r\nContent-Type: text/plain; charset=UTF-8\r\n"))
{
    // Email has sent successfully, echo a success page.

    header('Location: ' . $return_to . '?contact-form-sent=success');

    } else {
        header('Location: '. $return_to);
    }

?>