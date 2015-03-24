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
     * @var array|null
     */
    protected $lastState = null;

    /**
     * @var array
     */
    protected $errors = array(
        10001 => 'authentication success',
        10002 => 'get success',
        10003 => 'create success',
        10004 => 'update success',
        10005 => 'delete success',
        10006 => 'accepted success',
        10007 => 'accepted, but confirmation needed',

        20001 => 'unkown pending',

        30001 => 'unknown warning',

        60001 => 'not a HTTPS request',
        60002 => 'missing api key',
        60003 => 'missing authentication string',
        60004 => 'authentication failed',
        60005 => 'json decode error',
        60006 => 'signature invalid',
        60007 => 'undefined command property',
        60008 => 'missing raw data',
        60009 => 'missing signature',
        60010 => 'method not supported',
        60011 => 'resource not found',
        60012 => 'missing timestamp',
        60013 => 'validation failed',
        60014 => 'field not updateable',
        60015 => 'not enough credits',
        60016 => 'resouce has pending updates',
        60017 => 'contact is blocked',
        60018 => 'feature not supported',
        60019 => 'tld unknown',
        60020 => 'domain already exists',
        60021 => 'invalid number of nameservers',
        60022 => 'does not use system nameservers',
        60023 => 'resource not owned by user',
        60024 => 'can not withdraw positive amount',
        60025 => 'restrictions not fullfilled for topleveldomain',
        60026 => 'domain feature not supported',
        60027 => 'subscription capability exceeded',
        60028 => 'no active subscription',
        60029 => 'unknown',
        60030 => 'operation not allowed',
        60031 => 'domain has wrong status',

        70001 => 'command helper not found',
        70002 => 'command already executed'
    );

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
     * @throws \Easyname\RestApi\Exception
     */
    public function __call($method, $args)
    {
        $client = $this->client;

        $result = call_user_func_array(array($client, $method), $args);
        $this->lastState = (isset($result['status'])) ? $result['status'] : null;

        if (isset($result['status']['type']) && $result['status']['type'] == 'success') {
            return $result['data'];
        }

        throw $this->getError($result);
    }

    /**
     * Return last api state
     * @return array|null
     */
    public function getLastState()
    {
        return $this->lastState;
    }

    /**
     * @param array $result
     *
     * @return \Easyname\RestApi\Exception
     */
    protected function getError($result = array())
    {
        $message = isset($result['status']['message']) ? $result['status']['message'] : false;
        $code    = isset($result['status']['code']) ? $result['status']['code'] : false;

        if (!$message && $code && isset($this->errors[$code])) {
            $message = $this->errors[$code];
        }

        return new \Easyname\RestApi\Exception($message, $code);
    }

}
