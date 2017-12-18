<?php
/**
 * Created by PhpStorm.
 * User: imsil
 * Date: 17/12/17
 * Time: 20:07
 */

// Require the bundled autoload file - the path may need to change
// based on where you downloaded and unzipped the SDK
require './Twilio/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$sid = 'AC11257e267244b209cd12098edf1c148a';
$token = '44d9ee7f5785dbb087c057419201578c';
$client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
$client->messages->create(
// the number you'd like to send the message to
    '+16475710747',
    array(
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '+12893014089',
        // the body of the text message you'd like to send
        'body' => "Hey Jenny! Good luck on the bar exam!"
    )
);

?>