<?php

/*
 * This work is license under
 * Creative Commons Attribution-ShareAlike 3.0 Unported License
 * http://creativecommons.org/licenses/by-sa/3.0/
 */

namespace Freegli\Tests\Component\APNs;

use Freegli\Component\APNs\ConnectionFactory;
use Freegli\Test\NotificationHandler;

require __DIR__.'/NotificationTest.php';

/**
 * @author Xavier Briand <xavierbriand@gmail.com>
 */
class NotificationHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $cf = new ConnectionFactory();
        $nh = new NotificationHandler($cf, true);
        $notification = NotificationTest::getNotification();

        $nh->send($notification);
    }
}

namespace Freegli\Test;

use Freegli\Component\APNs\NotificationHandler as BaseNotificationHandler;

/**
 * NotificationHandler Mock.
 */
class NotificationHandler extends BaseNotificationHandler
{
    const PROTOCOL        = 'tcp';
    const PRODUCTION_HOST = 'localhost';
    const SANDBOX_HOST    = 'localhost';
    const PORT            = '80';
}
