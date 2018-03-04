<?php 
require 'vendor/autoload.php';
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseClient;
use Parse\ParsePushStatus;
use Parse\ParseServerInfo;
use Parse\ParseLogs;
use Parse\ParseAudience;
$app_id = 'VcmsRhwkQzMBHEORbnlAvvMQHzzuZmJViay5l7t4';
$rest_key = 'rNgOMJWbY9GhUc5FOABnFKzudwIwTBQIEqt9HmiJ';
$master_key = 'rNgOMJWbY9GhUc5FOABnFKzudwIwTBQIEqt9HmiJ';
ParseClient::initialize( $app_id, $rest_key, $master_key );
ParseClient::setServerURL('http://intellispex-env.us-east-1.elasticbeanstalk.com','parse');
$health = ParseClient::getServerHealth();
if($health['status'] === 200) {
    $query = ParseInstallation::query();
    $query->equalTo("userID", "cxeHjhpjIV");
$d = new DateTime();

// Output the microseconds.
//echo $d->format('u'); // 012345

// Output the date with microseconds.
$push_time =  $d->format('Y-m-d\TH:i:s.u'); // 2011-01-01T15:03:01.012345

    
    $response = ParsePush::send(array(
        "where" => $query,
        "data" => array(
          "alert" => "Hello, how are you?"
        )
    ),true);
    echo '<pre>';
    print_r($response);
    if(ParsePush::hasStatus($response)) {

        // Retrieve PushStatus object
        $pushStatus = ParsePush::getStatus($response);
        print_r($pushStatus);
        // get push status string
        $status = $pushStatus->getPushStatus();
        print_r($status);
        if($status == "succeeded") {
            // handle a successful push request

        } else if($status == "running") {
            // handle a running push request

        } else {
            // push request did not succeed

        }

        // get # pushes sent
        $sent = $pushStatus->getPushesSent();
        print_r($sent);
        // get # pushes faile;
        $failed = $pushStatus->getPushesFailed();

        print_r($failed);
    }
//    $query2 = new ParseQuery("_Installation");
//    $query2->EqualTo("userID", 'cxeHjhpjIV');
//    $results = $query2->find(true);
//    echo '<pre>';
////    print_r($results);
//
//    print_r($test);

}
?>