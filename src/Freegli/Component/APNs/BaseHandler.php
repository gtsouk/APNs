<?php

/*
 * This work is license under
 * Creative Commons Attribution-ShareAlike 3.0 Unported License
 * http://creativecommons.org/licenses/by-sa/3.0/
 */

namespace Freegli\Component\APNs;

/**
 * @author Xavier Briand <xavierbriand@gmail.com>
 */
abstract class BaseHandler
{
    const PROTOCOL = 'ssl';

    private $connectionFactory;
    private $profile;

    /**
     * @var resource
     */
    private $resource;

    /**
     * @var string
     */
    private $url;

    public function __construct($connectionFactory, $profile = null, $debug = false)
    {
        $this->connectionFactory = $connectionFactory;
        $this->profile           = $profile;

        $this->url = sprintf('%s://%s:%s',
            static::PROTOCOL,
            $debug ? static::SANDBOX_HOST : static::PRODUCTION_HOST,
            static::PORT
        );
    }

    public function __destruct()
    {
        $this->closeResource();
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        if (!$this->resource) {
            $this->resource = $this->connectionFactory->getConnection($this->url, $this->profile);
        }

        return $this->resource;
    }

    public function closeResource()
    {
        if (is_resource($this->resource)) {
            fclose($this->resource);
        }
        $this->resource = null;
    }
}
