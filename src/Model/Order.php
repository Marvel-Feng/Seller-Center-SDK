<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 3/24/19
 * Time: 1:18 PM
 */

namespace SellerCenter\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Order
{

    /**
     * Order Information Keys as retrieved from SellerCenter.
     */
    const SC_ORDER_ID                  = "OrderId";
    const SC_ORDER_NUMBER              = "OrderNumber";
    const SC_ORDER_PAYMENT_METHOD      = "PaymentMethod";
    const SC_ORDER_DELIVERY_INFO       = "DeliveryInfo";
    const SC_ORDER_CREATED_AT          = "CreatedAt";
    const SC_ORDER_UPDATED_AT          = "UpdatedAt";
    const SC_ORDER_PRICE               = "Price";
    const SC_ORDER_ADDRESS_SHIPPING    = "AddressShipping";
    const SC_ORDER_CUSTOMER_FIRST_NAME = "CustomerFirstName";
    const SC_ORDER_CUSTOMER_LAST_NAME  = "CustomerLastName";
    const SC_ORDER_STATUSES            = "Statuses";
    const SC_ORDER_STATUS              = "Status";
    const SC_ORDER_ITEMS               = "OrderItems";
    const SC_ORDER_ITEM                = "OrderItem";
    const SC_ORDERS                    = "Orders";
    const SC_ORDER                     = "Order";

    /**
     * @var string $orderId
     * @Assert\NotBlank()
     */
    protected $orderId;

    /**
     * @var string $orderNumber
     */
    protected $orderNumber;

    /** @var string $paymentMethod */
    protected $paymentMethod;

    /** @var string $deliveryInfo */
    protected $deliveryInfo;

    /** @var \DateTime $createdAt */
    protected $createdAt;

    /** @var \DateTime $updatedAt */
    protected $updatedAt;

    /** @var float $price */
    protected $price;

    /** @var AddressShipping $shippingAddress */
    protected $shippingAddress;

    /** @var string $customerFirstName */
    protected $customerFirstName;

    /** @var string $customerLastName */
    protected $customerLastName;

    /** @var string $status */
    protected $status;

    /** @var OrderItem[] $items */
    protected $items;

    /**
     * @param OrderItem $item
     */
    public function addItem(OrderItem $item)
    {
        $this->items[$item->getOrderItemId()] = $item;
    }

    /**
     * @return OrderItem[]
     */
    public function getActiveItems(): array
    {
        foreach ($this->getItems() as $item) {
            if ($item->getStatus() == OrderItem::SC_ORDER_ITEM_CANCELLED_STATUS) {
                $this->removeItem($item);
            }
        }

        return $this->getItems();
    }

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
    public function getCustomerFirstName(): string
    {
        return $this->customerFirstName;
    }

    /**
     * @param string $customerFirstName
     */
    public function setCustomerFirstName(string $customerFirstName): void
    {
        $this->customerFirstName = $customerFirstName;
    }

    /**
     * @return string
     */
    public function getCustomerLastName(): string
    {
        return $this->customerLastName;
    }

    /**
     * @param string $customerLastName
     */
    public function setCustomerLastName(string $customerLastName): void
    {
        $this->customerLastName = $customerLastName;
    }

    /**
     * @return string
     */
    public function getDeliveryInfo(): string
    {
        return $this->deliveryInfo;
    }

    /**
     * @param string $deliveryInfo
     */
    public function setDeliveryInfo(string $deliveryInfo): void
    {
        $this->deliveryInfo = $deliveryInfo;
    }

    /**
     * @return OrderItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param OrderItem[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
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
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * @param string $orderNumber
     */
    public function setOrderNumber(string $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     */
    public function setPaymentMethod(string $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return AddressShipping
     */
    public function getShippingAddress(): AddressShipping
    {
        return $this->shippingAddress;
    }

    /**
     * @param AddressShipping $shippingAddress
     */
    public function setShippingAddress(AddressShipping $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
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
     * @param OrderItem $item
     */
    public function removeItem(OrderItem $item)
    {
        unset($this->items[$item->getOrderItemId()]);
    }


}