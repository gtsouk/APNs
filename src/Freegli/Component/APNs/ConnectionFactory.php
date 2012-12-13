<?php

/*
 * This work is license under
 * Creative Commons Attribution-ShareAlike 3.0 Unported License
 * http://creativecommons.org/licenses/by-sa/3.0/
 */

namespace Freegli\Component\APNs;

use Freegli\Component\APNs\Exception\ConnectionException;

/**
 * @author Xavier Briand <xavierbriand@gmail.com>
 */
class ConnectionFactory
{
    protected $profiles;

    public function __construct()
    {
        $this->profiles = array();
    }

    /**
     * Add a profile (key path and pass phrase).
     *
     * @param string $name
     * @param string $certificatePath
     * @param string $certificatePassPhrase
     *
     * @return ConnectionFactory
     *
     * @throws InvalidArgumentException
     */
    public function addProfile($name, $certificatePath, $certificatePassPhrase = null)
    {
        if (!is_readable($certificatePath)) {
            throw new \InvalidArgumentException(sprintf('Unable to read certificate in "%s"', $certificatePath));
        }

        $this->profiles[$name] = array(
            'path'       => $certificatePath,
            'passPhrase' => $certificatePassPhrase,
        );

        return $this;
    }

    /**
     * Open stream connection to APNs.
     *
     * @param string $url Service URL to connect
     *
     * @return resource
     *
     * @throws ConnectionException
     */
    public function getConnection($url, $profile = null)
    {
        $streamContext = stream_context_create();

        $profile = $this->getProfile($profile);

        stream_context_set_option($streamContext, 'ssl', 'local_cert', $profile['path']);

        if (isset($profile['passPhrase'])) {
            stream_context_set_option($streamContext, 'ssl', 'passphrase', $profile['passPhrase']);
        }

        try {
            $connection = stream_socket_client($url, $errno, $errstr, 60, STREAM_CLIENT_CONNECT, $streamContext);
        } catch (\Exception $e) {
            throw new ConnectionException(sprintf('Unable to connect to "%s"', $url), null, $e);
        }
        if ($connection === false) {
            throw new ConnectionException($errstr, $errno);
        }

        stream_set_blocking($connection, 0);

        return $connection;
    }

    /**
     * Get profile by name or the first one.
     *
     * @param string $name
     *
     * @return array
     *
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    protected function getProfile($name = null)
    {
        if (empty($this->profiles)) {
            throw new \RuntimeException('No APNS profile defined');
        }

        if ($name) {
            if (isset($this->profiles[$name])) {
                return $this->profiles[$name];
            } else {
                throw new \InvalidArgumentException(sprintf('Undefined APNS profile "%s"', $name));
            }
        }

        return reset($this->profiles);
    }
}
