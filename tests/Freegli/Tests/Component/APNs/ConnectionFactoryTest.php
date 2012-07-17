<?php

/*
 * This work is license under
 * Creative Commons Attribution-ShareAlike 3.0 Unported License
 * http://creativecommons.org/licenses/by-sa/3.0/
 */

namespace Freegli\Tests\Component\APNs;

use Freegli\Component\APNs\ConnectionFactory;

/**
 * @author Xavier Briand <xavierbriand@gmail.com>
 */
class ConnectionFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $cf = new ConnectionFactory();
        $connection = $cf->getConnection('tcp://localhost:80');

        $this->assertTrue(is_resource($connection));
        $this->assertFalse(feof($connection));
        fclose($connection);
    }
}
