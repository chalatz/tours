<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// include 'class.IPInfoDB.php';

// $ipinfodb = new IPInfoDB('043542783908f8d1b64ecfbd312ee672570dabad52c780a3c52ad643c6a29f7b');
// $results = $ipinfodb->getCity($_SERVER['REMOTE_ADDR']);

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
// $ipAddress = $results['ipAddress'];
// $countryCode = $results['countryCode'];
// $countryName = $results['countryName'];
// $regionName = $results['regionName'];
// $cityName = $results['cityName'];
// $zipCode = $results['zipCode'];
// $timeZone = $results['timeZone'];

if(isset($_POST['spam_one'])){
    $spam_one = $_POST['spam_one'];
}
if(isset($_POST['spam_two'])){
    $spam_two = $_POST['spam_two'];
}
if(isset($_POST['return_to'])){
    $return_to = $_POST['return_to'];
}
if(isset($_POST['from_page'])){
    $from_page = $_POST['from_page'];
}
if(isset($_POST['first_name'])){
    $first_name = $_POST['first_name'];
}
if(isset($_POST['last_name'])){
    $last_name = $_POST['last_name'];
}
if(isset($_POST['reservation_name'])){
    $reservation_name = $_POST['reservation_name'];
}
if(isset($_POST['city_state_zip'])){
    $city_state_zip = $_POST['city_state_zip'];
}
if(isset($_POST['phone_fax'])){
    $phone_fax = $_POST['phone_fax'];
}
if(isset($_POST['e_mail'])){
    $e_mail = $_POST['e_mail'];
}
if(isset($_POST['date11_month'])){
    $date11_month = $_POST['date11_month'];
}
if(isset($_POST['date11_month'])){
    $date11_month = $_POST['date11_month'];
}
if(isset($_POST['date11_date'])){
    $date11_date = $_POST['date11_date'];
}
if(isset($_POST['date11_year'])){
    $date11_year = $_POST['date11_year'];
}
if(isset($_POST['date11_year'])){
    $date11_year = $_POST['date11_year'];
}
if(isset($_POST['ship_flight_num'])){
    $ship_flight_num = $_POST['ship_flight_num'];
}
if (isset($_POST['type_of_tour'])){
    $type_of_tour = $_POST['type_of_tour'];
}
if(isset($_POST['speaking_language'])){
    $speaking_language = $_POST['speaking_language'];
}
if(isset($_POST['party_num'])){
    $party_num = $_POST['party_num'];
}
if(isset($_POST['comments'])){
    $comments = $_POST['comments'];
}

// $address = "request@rhodestoursexcursions.com";

$e_subject = 'New request from ' . $e_mail . '.';

$msg = "Details:\r\n\n";

$msg .= "From: $from_page\r\n";
$msg .= "First Name: $first_name\r\n";
$msg .= "Last Name: $last_name\r\n";
$msg .= "Services to be reserved in the name(s): $reservation_name\r\n";
$msg .= "City/State/Country: $city_state_zip\r\n";
$msg .= "Phone/Fax: $phone_fax\r\n";
$msg .= "E-mail: $e_mail\r\n";
$msg .= "Private Tour Date: $date11_month - $date11_date - $date11_year\r\n";
$msg .= "Private Tour Start Location Hotel / Cruise Ship / Flight Number: $ship_flight_num\r\n";
$msg .= "Type of Tour: $type_of_tour\r\n";
$msg .= "Language: $speaking_language\r\n";
$msg .= "Number in party: $party_num\r\n";
$msg .= "Comments:\r\n $comments\r\n";

// $msg .= "Ip Address: $ipAddress\r\n";
// $msg .= "Country Code: $countryCode\r\n";
// $msg .= "Country Name: $countryName\r\n";
// $msg .= "Region Name: $regionName\r\n";
// $msg .= "City Name: $cityName\r\n";
// $msg .= "Zip Code: $zipCode\r\n";
// $msg .= "Time Zone: $timeZone\r\n";

if(!empty($_POST))
{
    // header('Location: ' . $return_to . '?contact-form-sent=success');

    // echo "<div id='succsess_page'>";
    // echo "<h1>Email Sent Successfully!</h1>";
    // echo "<p>Thank you <strong>$last_name</strong>, your message has been submitted to us.</p>";
    // echo "</div>";

    echo nl2br($msg);

    } else {
        header('Location: '. $return_to);
    }
    
// if(mail($address, $e_subject, $msg, "From: $e_mail\r\nReply-To: $e_mail\r\nReturn-Path: $e_mail\r\n"))
// {
//     // Email has sent successfully, echo a success page.

//     header('Location: '. $return_to ."'");

//     echo "<div id='succsess_page'>";
//     echo "<h1>Email Sent Successfully.</h1>";
//     echo "<p>Thank you <strong>$last_name</strong>, your message has been submitted to us.</p>";
//     echo "</div>";

//     } else echo "Error. Mail not sent";

?>