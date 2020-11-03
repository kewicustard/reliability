<?php 
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "statistics@mea.or.th";
    $to = "kuladet.ri@mea.or.th";
    $subject = "PHP Mail Test script";
    $message = "This is a test to check the PHP Mail functionality";
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    echo "Test email sent";
?>