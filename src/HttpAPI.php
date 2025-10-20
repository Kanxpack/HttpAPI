<?php
namespace Kanxpack\HttpAPI;

use Kanxpack\CurlGet\CurlGet;
use Kanxpack\HttpClient\HttpClient;
use Kanxpack\HttpClient\HttpResponseMessage;

class HttpAPI {

	private static $instance;
	protected static $httpResponseMessage;
    protected static $httpClient;
    
    public static function getInstance() : self
    { 
    	return empty(self::$instance) ? (new self()) : self::$instance; 
    }

    protected static function setHttpResponseMessage(\Kanxpack\HttpClient\HttpResponseMessage $httpResponseMessage) : self
    {
        self::$httpResponseMessage = $httpResponseMessage;
        return self::getInstance();
    }

    public static function getHttpResponseMessage() : \Kanxpack\HttpClient\HttpResponseMessage
    {
        return self::$httpResponseMessage;
    }

    protected static function setHttpClient(\Kanxpack\HttpClient\HttpClient $httpClient) : self
    {
        self::$httpClient = $httpClient;
        return self::getInstance();
    }

    public static function getHttpClient() : \Kanxpack\HttpClient\HttpClient
    {
        return self::$httpClient;
    }

	public static function get(string $url) : self
	{
        self::setHttpClient(HttpClient::get($url));
        self::setHttpResponseMessage(self::getHttpClient()->getHttpResponseMessage());
		return self::getInstance();
	}

    public static function getResult() : array
    {
        return isset(self::getHttpClient()->getHttpResponseMessage()->getResponse()['result']) ? self::getHttpClient()->getHttpResponseMessage()->getResponse()['result'] : [];
    }

    public static function getStatus() : string
    {
        return isset(self::getHttpClient()->getHttpResponseMessage()->getResponse()['status']) ? self::getHttpClient()->getHttpResponseMessage()->getResponse()['status'] : "404";
    }

    public static function isStatus200() : bool
    {
        if (self::getStatus() == '200') {
            return true;
        }
        return false;
    }

    public static function isStatus404() : bool
    {
        if (self::getStatus() == '404') {
            return true;
        }
        return false;
    }

    public static function isStatusSuccess() : bool
    {
        return self::isStatus200();
    }

    public static function isStatusNotFound() : bool
    {
        return self::isStatus404();
    }

    public static function isStatus(string $status) : bool
    {
        if (self::getStatus() == $status) {
            return true;
        }
        return false;
    }

}