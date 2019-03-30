<?php

namespace SellerCenter\Model;

use SellerCenter\Model\Configuration;
use Symfony\Component\Validator\Constraints as Assert;

class Request
{
    const QUERY_PARAMETER_ACTION            = 'Action';
    const QUERY_PARAMETER_VERSION           = 'Version';
    const QUERY_PARAMETER_TIMESTAMP         = 'Timestamp';
    const QUERY_PARAMETER_USER_ID           = 'UserID';
    const QUERY_PARAMETER_SIGNATURE         = 'Signature';
    const QUERY_PARAMETER_FORMAT            = 'Format';
    const QUERY_PARAMETER_ORDER_ID          = 'OrderId';
    const QUERY_PARAMETER_ORDER_ID_LIST     = 'OrderIdList';
    const QUERY_PARAMETER_PRIMARY_CATEGORY  = 'PrimaryCategory';
    const QUERY_PARAMETER_FEED_ID           = 'FeedID';
    const QUERY_PARAMETER_FEED_ID_LIST      = 'FeedIdList';
    const QUERY_PARAMETER_SKU_SELLER_LIST   = 'SkuSellerList';
    const QUERY_PARAMETER_LIMIT             = 'Limit';
    const QUERY_PARAMETER_OFFSET            = 'Offset';
    const QUERY_PARAMETER_STATUS            = 'Status';
    const QUERY_PARAMETER_FILTER            = 'Filter';
    const QUERY_PARAMETER_CREATED_AFTER     = 'CreatedAfter';
    const QUERY_PARAMETER_CREATED_BEFORE    = 'CreatedBefore';
    const QUERY_PARAMETER_UPDATED_AFTER     = 'UpdatedAfter';
    const QUERY_PARAMETER_UPDATED_BEFORE    = 'UpdatedBefore';
    const QUERY_PARAMETER_ORDER_ITEM_ID     = 'OrderItemId';
    const QUERY_PARAMETER_ORDER_ITEM_IDS    = 'OrderItemIds';
    const QUERY_PARAMETER_DELIVERY_TYPE     = 'DeliveryType';
    const QUERY_PARAMETER_SHIPPING_PROVIDER = 'ShippingProvider';
    const QUERY_PARAMETER_REASON            = 'Reason';
    const QUERY_PARAMETERS_REASON_DETAILS   = 'ReasonDetail';
    const QUERY_PARAMETER_ITEM_PRICE        = 'ItemPrice';
    const QUERY_PARAMETER_CRATED_AT         = 'CreatedAt';
    const QUERY_PARAMETER_SKU               = 'Sku';
    const QUERY_PARAMETER_SORT_BY           = 'SortBy';
    const QUERY_PARAMETER_SORT_DIRECTION    = 'SortDirection';
    const QUERY_PARAMETER_TRACKING_NUMBER   = 'TrackingNumber';
    const QUERY_PARAMETER_SERIAL_NUMBER     = 'SerialNumber';

    const ACTION_GET_METRICS                   = "GetMetrics";
    const ACTION_GET_STATISTICS                = "GetStatistics";
    const ACTION_GET_PRODUCTS                  = "GetProducts";
    const ACTION_PRODUCT_CREATE                = "ProductCreate";
    const ACTION_PRODUCT_UPDATE                = "ProductUpdate";
    const ACTION_GET_CATEGORY_TREE             = "GetCategoryTree";
    const ACTION_GET_BRANDS                    = "GetBrands";
    const ACTION_GET_ORDERS                    = "GetOrders";
    const ACTION_GET_ORDER                     = "GetOrder";
    const ACTION_GET_ORDER_ITEMS               = "GetOrderItems";
    const ACTION_GET_MULTI_ORDER_ITEMS         = "GetMultipleOrderItems";
    const ACTION_GET_CATEGORY_ATTRIBUTES       = "GetCategoryAttributes";
    const ACTION_GET_FEED_STATUS               = "FeedStatus";
    const ACTION_GET_FEED_RAW_INPUT            = "GetFeedRawInput";
    const ACTION_IMAGE                         = "Image";
    const ACTION_SET_CANCELLED_STATUS          = "SetStatusToCanceled";
    const ACTION_GET_FAILURE_REASONS           = "GetFailureReasons";
    const ACTION_GET_SHIPMENT_PROVIDERS        = "GetShipmentProviders";
    const ACTION_SET_READY_TO_SHIP_STATUS      = "SetStatusToReadyToShip";
    const ACTION_SET_TO_SHIPPED_STATUS         = "SetStatusToShipped";
    const ACTION_SET_TO_FAILED_DELIVERY_STATUS = "SetStatusToFailedDelivery";
    const ACTION_SET_TO_DELIVERED_STATUS       = "SetStatusToDelivered";

    const VALID_ACTIONS
        = [
            self::ACTION_GET_METRICS,
            self::ACTION_GET_STATISTICS,
            self::ACTION_GET_PRODUCTS,
            self::ACTION_PRODUCT_CREATE,
            self::ACTION_PRODUCT_UPDATE,
            self::ACTION_GET_CATEGORY_TREE,
            self::ACTION_GET_BRANDS,
            self::ACTION_GET_ORDERS,
            self::ACTION_GET_ORDER,
            self::ACTION_GET_ORDER_ITEMS,
            self::ACTION_GET_MULTI_ORDER_ITEMS,
            self::ACTION_GET_CATEGORY_ATTRIBUTES,
            self::ACTION_GET_FEED_STATUS,
            self::ACTION_GET_FEED_RAW_INPUT,
            self::ACTION_IMAGE,
            self::ACTION_SET_CANCELLED_STATUS,
            self::ACTION_GET_FAILURE_REASONS,
            self::ACTION_GET_SHIPMENT_PROVIDERS,
            self::ACTION_SET_READY_TO_SHIP_STATUS,
        ];

    /** @var string $baseUrl */
    public $baseUrl = '';

    /** @var string $method */
    public $method = 'GET';

    /** @var string $path */
    public $path = '';

    /** @var array $headers */
    public $headers = [];

    /** @var array $parameters */
    public $parameters = [];

    /** @var mixed $body */
    public $body = null;

    /** @var string $userId */
    private $userId;

    /** @var string $apiKey */
    private $apiKey;

    /** @var string $version */
    private $version;

    /** @var string $username */
    private $username;

    /** @var string $password */
    private $password;

    /**
     * @var string $action
     * @Assert\Choice(choices=Request::VALID_ACTIONS)
     */
    private $action;

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
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
    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->baseUrl.$this->path;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
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
    public function setUsername(string $username): void
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
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @param Configuration $account
     *
     */
    public function addConfiguration(Configuration $account)
    {
        $this->setBaseUrl($account->getUrl());
        $this->setApiKey($account->getApiKey());
        $this->setUsername($account->getUsername());
        $this->setPassword($account->getApiPassword());
        $this->setVersion($account->getVersion());
        $this->setUserId($account->getEmail());
    }
}