<?php
$to_email = "@gmail.com";
$subject = "Simple Email Test via PHP";
$body = "Hi, This is test email send by PHP Script";
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html\r\n";
// $headers .= 'From: from@gmail.com';
$headers .= "From: mayanksalvi.8@gmail.com" . "\r\n";

if (mail($to_email, $subject, $body, $headers)) {
    echo "Email successfully sent to $to_email...";
} else {
    echo "Email sending failed...";
    print_r(error_get_last()['message']);
}