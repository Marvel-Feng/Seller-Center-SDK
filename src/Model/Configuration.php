<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 3/27/19
 * Time: 2:59 PM
 */

namespace SellerCenter\Model;

use SellerCenter\Http\Client;

class Configuration
{
    /**
     * @var string $url
     */
    protected $url;

    /**
     * @var string $email
     */
    protected $email;


    /**
     * @var string $apiKey
     */
    protected $apiKey;

    /**
     * @var string $apiPassword
     */
    protected $apiPassword;


    /**
     * @var string $username
     */
    protected $username;


    /**
     * @var string $version
     */
    protected $version;

    /**
     * @var int $maxAttemptsDelay
     */
    protected $maxAttemptsDelay = Client::MAX_ATTEMPTS_DELAY;

    /**
     * @var int $minAttemptsDelay
     */
    protected $minAttemptsDelay = Client::MIN_ATTEMPTS_DELAY;

    /**
     * @var int $requestAttemptsThreshold
     */
    protected $requestAttemptsThreshold = Client::REQUEST_ATTEMPTS_THRESHOLD;

    /**
     * Configuration constructor.
     *
     * @param string $url
     * @param string $email
     * @param string $apiKey
     * @param string $apiPassword
     * @param string $username
     * @param string $version
     */
    public function __construct(
        string $url,
        string $email,
        string $apiKey,
        string $apiPassword,
        string $username,
        string $version
    ) {
        $this->url         = $url;
        $this->email       = $email;
        $this->apiKey      = $apiKey;
        $this->apiPassword = $apiPassword;
        $this->username    = $username;
        $this->version     = $version;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getApiPassword(): string
    {
        return $this->apiPassword;
    }

    /**
     * @param string $apiPassword
     */
    public function setApiPassword(string $apiPassword)
    {
        $this->apiPassword = $apiPassword;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * @return int
     */
    public function getMaxAttemptsDelay(): int
    {
        return $this->maxAttemptsDelay;
    }

    /**
     * @param int $maxAttemptsDelay
     */
    public function setMaxAttemptsDelay(int $maxAttemptsDelay): void
    {
        $this->maxAttemptsDelay = $maxAttemptsDelay;
    }

    /**
     * @return int
     */
    public function getMinAttemptsDelay(): int
    {
        return $this->minAttemptsDelay;
    }

    /**
     * @param int $minAttemptsDelay
     */
    public function setMinAttemptsDelay(int $minAttemptsDelay): void
    {
        $this->minAttemptsDelay = $minAttemptsDelay;
    }

    /**
     * @return int
     */
    public function getRequestAttemptsThreshold(): int
    {
        return $this->requestAttemptsThreshold;
    }

    /**
     * @param int $requestAttemptsThreshold
     */
    public function setRequestAttemptsThreshold(int $requestAttemptsThreshold): void
    {
        $this->requestAttemptsThreshold = $requestAttemptsThreshold;
    }

}