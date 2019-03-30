<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 3/24/19
 * Time: 1:23 PM
 */

namespace SellerCenter\Model;

use Symfony\Component\Validator\Constraints as Assert;

class AddressShipping
{

    /**
     * Shipping address information as retrieved from SellerCenter.
     */
    const SC_SHIPPING_FIRST_NAME     = "FirstName";
    const SC_SHIPPING_LAST_NAME      = "LastName";
    const SC_SHIPPING_PHONE          = "Phone";
    const SC_SHIPPING_PHONE_2        = "Phone2";
    const SC_SHIPPING_ADDRESS_1      = "Address1";
    const SC_SHIPPING_ADDRESS_2      = "Address2";
    const SC_SHIPPING_CUSTOMER_EMAIL = "CustomerEmail";
    const SC_SHIPPING_CITY           = "City";
    const SC_SHIPPING_POST_CODE      = "PostCode";
    const SC_SHIPPING_COUNTRY        = "Country";

    /**
     * @var string $firstName
     * @Assert\NotBlank()
     */
    protected $firstName;

    /**
     * @var string $lastName
     * @Assert\NotBlank()
     */
    protected $lastName;

    /**
     * @var $phone
     * @Assert\NotBlank()
     */
    protected $phone;

    /**
     * @var $address1
     * @Assert\NotBlank()
     */
    protected $address1;

    /**
     * @var $customerEmail
     */
    protected $customerEmail;

    /**
     * @var $city
     * @Assert\NotBlank()
     */
    protected $city;

    /**
     * @var $country
     * @Assert\NotBlank()
     */
    protected $country;

    /** @var Order $order */
    protected $order;

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param mixed $address1
     */
    public function setAddress1($address1): void
    {
        $this->address1 = $address1;
    }

    /**
     * @return mixed
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @param mixed $customerEmail
     */
    public function setCustomerEmail($customerEmail): void
    {
        $this->customerEmail = $customerEmail;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
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
     * Sets the Customer email to hash if it is empty. A workaround since SellerCenter does'nt return email address.
     *
     * @return void
     */
    public function setCustomerHashedEmail()
    {
        $customerEmail = $this->getCustomerEmail();
        if (!isset($customerEmail) || empty($customerEmail)) {
            $this->setCustomerEmail(sha1(strrev(md5($this->getPhone()))).'@edfa3ly.com');
        }
    }


}