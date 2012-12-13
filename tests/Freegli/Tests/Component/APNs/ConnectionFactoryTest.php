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
    /**
     * @expectedException RuntimeException
     */
    public function testGivinNoProfileShouldThrowAnException()
    {
        $cf = new ConnectionFactory();
        $connection = $cf->getConnection('tcp://localhost:80');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGivenAnUnreadableCertificateShouldThrowAnException()
    {
        $cf = new ConnectionFactory();
        $cf->addProfile('foo', 'bar');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWhenRequestingAnUndefinedProfileShouldThrowAnException()
    {
        $cf = new ConnectionFactory();
        $cf->addProfile('foo', __file__);
        $cf->getConnection('tcp://localhost:80', 'bar');
    }
}
