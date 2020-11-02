<?php

$debug = false;

if($debug == true){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

include 'class.IPInfoDB.php';

$infodb_api_key = include '_infodb_key.php';

$ipinfodb = new IPInfoDB($infodb_api_key);
$results = $ipinfodb->getCity($_SERVER['REMOTE_ADDR']);

$apots = include '_apots.php';

$return_to = '';
$from_page = '';
$page_url = '';
$first_name = '';
$e_mail = '';
$comments = '';
$the_page = '';
$apot = '';

$ipAddress = $results['ipAddress'];
$countryCode = $results['countryCode'];
$countryName = $results['countryName'];
$regionName = $results['regionName'];
$cityName = $results['cityName'];
$zipCode = $results['zipCode'];
$timeZone = $results['timeZone'];

$return_to = $_POST['return_to'];
$the_page = $_POST['the_page'];
$from_page = $_POST['from_page'];
$page_url = $_POST['page_url'];
$first_name = $_POST['first_name'];
$e_mail = $_POST['e_mail'];
$comments = $_POST['comments'];
$apot = trim($_POST['apot']);

if(array_key_exists($the_page, $apots)) {
    $the_apot = $apots[$the_page];
} else {
    $the_apot = 5;
}

$address = "request@rhodesprivatetours.com";

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
$msg .= "Time Zone: $timeZone\r\n";

function passed(){

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
    if(isset($_POST['apot']) && $_POST['apot'] == ''){
        return false;
    }

    return true;
}

function passed_nocaptcha($apot, $the_apot){

    if (passed()) {        
        if ($apot == $the_apot) {
            return true;
        } else {
            return false;
        }
    }
}

if($debug == true){
    if(validated()) {
        if(passed_nocaptcha($apot, $the_apot))
        {
            // Email has sent successfully, echo a success page.
    
            header('Location: ' . $return_to . '?contact-form-sent=success');
    
        } else {
            header('Location: '. $return_to . '?contact-form-sent=fail');
        }
    } else {
        header('Location: '. $return_to . '?contact-form-sent=validation-error');
    }
} else {
    if(validated()) {
        if(passed_nocaptcha($apot, $the_apot) && mail($address, $e_subject, $msg, "From: $e_mail\r\nReply-To: $e_mail\r\nReturn-Path: $e_mail\r\nContent-Type: text/plain; charset=UTF-8\r\n"))
        {
            // Email has sent successfully, echo a success page.
    
            header('Location: ' . $return_to . '?contact-form-sent=success');
    
        } else {
            header('Location: '. $return_to . '?contact-form-sent=fail');
        }
    } else {
        header('Location: '. $return_to . '?contact-form-sent=validation-error');
    }

}

// if($debug) {
//     if(validated()) {
//         if(passed_nocaptcha($apot, $the_apot))
//         {
//             var_dump($_POST);
//             echo '<br>';
//             echo '<br>';
//             var_dump($msg);
//             echo '<br>';
//             echo '<br>';
//             var_dump($the_apot);
//             die();
//         }
//     }
// }

?>