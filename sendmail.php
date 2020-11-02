<?php

$debug = false;

if ($debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

include 'class.IPInfoDB.php';

$infodb_api_key = include '_infodb_key.php';

$ipinfodb = new IPInfoDB($infodb_api_key);
$results = $ipinfodb->getCity($_SERVER['REMOTE_ADDR']);

$return_to = '';
$from_page = '';
$first_name = '';
$last_name = '';
$reservation_name = '';
$city_state_zip = '';
$phone_fax = '';
$e_mail = '';
$date11_month = '';
$date11_month = '';
$date11_date = '';
$date11_year = '';
$date11_year = '';
$ship_flight_num = '';
$type_of_tour = '';
$speaking_language = '';
$party_num = '';
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
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$reservation_name = $_POST['reservation_name'];
$city_state_zip = $_POST['city_state_zip'];
$phone_fax = $_POST['phone_fax'];
$e_mail = $_POST['e_mail'];
$date11_month = $_POST['date11_month'];
$date11_month = $_POST['date11_month'];
$date11_date = $_POST['date11_date'];
$date11_year = $_POST['date11_year'];
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

if ($debug) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    if (passed()) {
        echo 'passed!';
    } else {
        echo 'failed!';
    }
    die();
}

$address = "request@rhodesprivatetours.com";

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
$msg .= "Time Zone: $timeZone\r\n";

$headers = "Content-Type: text/html; charset=UTF-8";

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

if(passed_recaptcha() && mail($address, $e_subject, $msg, "From: $e_mail\r\nReply-To: $e_mail\r\nReturn-Path: $e_mail\r\nContent-Type: text/plain; charset=UTF-8\r\n")){
    // Email has sent successfully, echo a success page.

    header('Location: ' . $return_to . '?contact-form-sent=success');

} else {
    header('Location: '. $return_to . '?contact-form-sent=fail');
}

?>