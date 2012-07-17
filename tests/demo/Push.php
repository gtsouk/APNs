<?php

/*
 * This work is license under
 * Creative Commons Attribution-ShareAlike 3.0 Unported License
 * http://creativecommons.org/licenses/by-sa/3.0/
 */

/*
 * @author Xavier Briand <xavierbriand@gmail.com>
 */

use Freegli\Component\APNs;
use Freegli\Component\APNs\Exception\ExceptionInterface;

require __DIR__.'/../bootstrap.php';

function handleError($errno, $errstr, $errfile, $errline, array $errcontext)
{
    throw new \Exception("$errstr in $errfile at line $errline", $errno);
}
set_error_handler('handleError');

$notification = new APNs\Notification();
$notification->setPayload(array(
    'aps' => array(
        'alert' => 'Alert!'
    )
));

//use your own signature
$cf = new APNs\ConnectionFactory(__DIR__.'/../Resources/apns-sandbox.pem');
$nh = new APNs\NotificationHandler($cf, true);

$i     = 1;
$limit = 500000;
while ($i++ < $limit) {
    $notification->setIdentifier($i);
    $notification->setDeviceToken(substr(sha1(mt_rand()), 0, 32));

    $retry = 5;
    while ($retry) {
        try {
            $nh->send($notification);
            echo '.';
            break;
        } catch (ExceptionInterface $e) {
            $retry--;
        }
    }
}

