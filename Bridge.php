<?php
/*
 * This file is part of EasynameBridgeBundle
 *
 * (c)2014 Ludwig Ruderstaller <lr@cwd.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cwd\EasynameBridgeBundle;

use Easyname\RestApi\Client;

/**
 * Class Easyname PHP SDK Bridge
 *
 * @package Cwd\EasynameBridgeBundle
 * @author  Ludwig Ruderstaller <lr@cwd.at>
 */
class Bridge
{
    /**
     * @var Client|null
     */
    protected $client = null;

    /**
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->client = new Client($config);
    }

    /**
     * @param string $method
     * @param array  $args
     *
     * @return array
     */
    public function __call($method, $args)
    {
        $client = $this->client;

        return call_user_func_array(array($client, $method), $args);
    }
}
