<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 3/24/19
 * Time: 1:19 PM
 */

namespace SellerCenter\Model;

use Symfony\Component\Validator\Constraints as Assert;

class OrderItem
{

    const SC_ORDER_ITEM_ID            = "OrderItemId";
    const SC_ORDER_ITEM_ORDER_ID      = "OrderId";
    const SC_ORDER_ITEM_NAME          = "Name";
    const SC_ORDER_ITEM_SKU           = "Sku";
    const SC_ORDER_ITEM_SHOP_SKU      = "ShopSku";
    const SC_ORDER_ITEM_CURRENCY      = "Currency";
    const SC_ORDER_ITEM_SHIPPING_TYPE = "ShippingType";
    const SC_ORDER_ITEM_PRICE         = "ItemPrice";
    const SC_ORDER_ITEM_STATUS        = "Status";
    const SC_ORDER_ITEM_CREATED_AT    = "CreatedAt";
    const SC_ORDER_ITEM_UPDATED_AT    = "UpdatedAt";
    const SC_ORDER_ITEM_TRACKING_CODE = "TrackingCode";
    const SC_ORDER_ITEM_ORDER_ITEMS   = "OrderItems";
    const SC_ORDER_ITEM_ORDER_ITEM    = "OrderItem";


    /**
     * Item statuses.
     */
    const SC_ORDER_ITEM_CANCELLED_STATUS     = "canceled";
    const SC_ORDER_ITEM_PENDING_STATUS       = "pending";
    const SC_ORDER_ITEM_READY_TO_SHIP_STATUS = "ready_to_ship";
    const SC_ORDER_ITEM_SHIPPED_STATUS       = "shipped";
    const SC_ORDER_ITEM_DELIVERED_STATUS     = "delivered";

    /**
     * Possible values for ShippingType
     */
    const SHIPPING_TYPE_OWN_WAREHOUSE        = "Own Warehouse";
    const SHIPPING_TYPE_DROP_SHIPPING        = "Dropshipping";

    /**
     * @var string $orderItemId
     * @Assert\NotBlank()
     */
    public $orderItemId;

    /**
     * @var string $Sku
     * @Assert\NotBlank()
     */
    public $Sku;

    /**
     * @var string $itemPrice
     */
    public $itemPrice;

    /**
     * @var string $Currency
     */
    public $Currency;

    /**
     * This Business order id concatenated with domain
     *
     * @var string $externalOrderId
     */
    public $externalOrderId;

    /**
     * @var Order $order
     */
    private $order;

    /**
     * @var string $status
     * */
    private $status;

    /**
     * @var string $orderId
     * OrderID (SellerCenter Order ID) as retrieved from SellerCenter.
     */
    private $orderId;

    /**
     * @var \DateTime $createdAt
     */
    private $createdAt;

    /**
     * @var string $name
     *
     */
    private $name;

    /**
     * @var \DateTime $updatedAt
     */
    private $updatedAt;

    /**
     * @var Order $edfa3lyOrder
     */
    private $edfa3lyOrder;


    /** @var string $trackingCode */
    private $trackingCode;


    /** @var string $shippingType */
    private $shippingType;

    /**
     * This field is used internally doesn't represent data from the actual SellerCenterOrderItem received from SC
     *
     * @var bool $isCancelled
     */
    private $isCancelled = false;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->Currency;
    }

    /**
     * @param string $Currency
     */
    public function setCurrency(string $Currency): void
    {
        $this->Currency = $Currency;
    }

    /**
     * @return Order
     */
    public function getEdfa3lyOrder(): Order
    {
        return $this->edfa3lyOrder;
    }

    /**
     * @param Order $edfa3lyOrder
     */
    public function setEdfa3lyOrder(Order $edfa3lyOrder): void
    {
        $this->edfa3lyOrder = $edfa3lyOrder;
    }

    /**
     * @return string
     */
    public function getExternalOrderId(): string
    {
        return $this->externalOrderId;
    }

    /**
     * @param string $externalOrderId
     */
    public function setExternalOrderId(string $externalOrderId): void
    {
        $this->externalOrderId = $externalOrderId;
    }

    /**
     * @return string
     */
    public function getItemPrice(): string
    {
        return $this->itemPrice;
    }

    /**
     * @param string $itemPrice
     */
    public function setItemPrice(string $itemPrice): void
    {
        $this->itemPrice = $itemPrice;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getOrderItemId(): string
    {
        return $this->orderItemId;
    }

    /**
     * @param string $orderItemId
     */
    public function setOrderItemId(string $orderItemId): void
    {
        $this->orderItemId = $orderItemId;
    }

    /**
     * @return string
     */
    public function getShippingType(): string
    {
        return $this->shippingType;
    }

    /**
     * @param string $shippingType
     */
    public function setShippingType(string $shippingType): void
    {
        $this->shippingType = $shippingType;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->Sku;
    }

    /**
     * @param string $Sku
     */
    public function setSku(string $Sku): void
    {
        $this->Sku = $Sku;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getTrackingCode(): string
    {
        return $this->trackingCode;
    }

    /**
     * @param string $trackingCode
     */
    public function setTrackingCode(string $trackingCode): void
    {
        $this->trackingCode = $trackingCode;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->isCancelled;
    }

    /**
     * @param bool $isCancelled
     */
    public function setIsCancelled(bool $isCancelled): void
    {
        $this->isCancelled = $isCancelled;
    }

}