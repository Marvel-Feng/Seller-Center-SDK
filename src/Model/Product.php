<?php
/**
 * Created by PhpStorm.
 * User: nour
 * Date: 10/31/17
 * Time: 8:00 PM
 */

namespace SellerCenter\Model;

class Product
{

    /**
     * The three possible product statuses.
     */
    const SELLER_CENTER_PRODUCT_ACTIVE_STATUS    = 'active';
    const SELLER_CENTER_PRODUCT_INACTIVE_STATUS  = 'inactive';
    const SELLER_CENTER_PRODUCT_DELETED_STATUS   = 'deleted';
    const SELLER_CENTER_PRODUCT_CANCELLED_STATUS = 'canceled';


    /**
     * Product state which is different from status!!!!!!!!!!
     * These are used for the products that already exist on SC.
     */
    const SC_PRODUCT_STATE_LIVE          = 'live';
    const SC_PRODUCT_STATE_INACTIVE      = 'inactive';
    const SC_PRODUCT_STATE_DELETED       = 'deleted';
    const SC_PRODUCT_STATE_IMAGE_MISSING = 'image-missing';
    const SC_PRODUCT_STATE_PENDING       = 'pending';
    const SC_PRODUCT_STATE_REJECTED      = 'rejected';
    const SC_PRODUCT_STATE_SOLD_OUT      = 'sold-out';


    /**
     * Array of all the statuses above.
     */
    const SELLER_CENTER_PRODUCT_STATUSES_ARRAY
        = [
            self::SELLER_CENTER_PRODUCT_ACTIVE_STATUS   => self::SELLER_CENTER_PRODUCT_ACTIVE_STATUS,
            self::SELLER_CENTER_PRODUCT_INACTIVE_STATUS => self::SELLER_CENTER_PRODUCT_INACTIVE_STATUS,
            self::SELLER_CENTER_PRODUCT_DELETED_STATUS  => self::SELLER_CENTER_PRODUCT_DELETED_STATUS,
        ];

    /**
     * Array of all product states.
     */
    const SELLER_CENTER_PRODUCT_STATES_ARRAY
        = [
            self::SC_PRODUCT_STATE_LIVE,
            self::SC_PRODUCT_STATE_INACTIVE,
            self::SC_PRODUCT_STATE_DELETED,
            self::SC_PRODUCT_STATE_IMAGE_MISSING,
            self::SC_PRODUCT_STATE_PENDING,
            self::SC_PRODUCT_STATE_REJECTED,
            self::SC_PRODUCT_STATE_SOLD_OUT,
        ];

    /** Product conditions */
    const SELLER_CENTER_PRODUCT_NEW_CONDITION         = 'new';
    const SELLER_CENTER_PRODUCT_USED_CONDITION        = 'used';
    const SELLER_CENTER_PRODUCT_REFURBISHED_CONDITION = 'refurbished';

    const SELLER_CENTER_PRODUCT_CONDITIONS_ARRAY
        = [
            self::SELLER_CENTER_PRODUCT_NEW_CONDITION         => self::SELLER_CENTER_PRODUCT_NEW_CONDITION,
            self::SELLER_CENTER_PRODUCT_USED_CONDITION        => self::SELLER_CENTER_PRODUCT_USED_CONDITION,
            self::SELLER_CENTER_PRODUCT_REFURBISHED_CONDITION => self::SELLER_CENTER_PRODUCT_REFURBISHED_CONDITION,
        ];


    /**
     * XML Request Tags
     * SC stands for seller center
     *
     */
    const SC_PRODUCT                   = 'Product';
    const SC_PRODUCTS                  = 'Products';
    const SC_PRODUCT_SELLER_SKU        = 'SellerSku';
    const SC_PRODUCT_PARENT_SKU        = 'ParentSku';
    const SC_PRODUCT_STATUS            = 'Status';
    const SC_PRODUCT_NAME              = 'Name';
    const SC_PRODUCT_VARIATION         = 'Variation';
    const SC_PRODUCT_PRIMARY_CATEGORY  = 'PrimaryCategory';
    const SC_PRODUCT_CATEGORIES        = 'Categories';
    const SC_PRODUCT_DESCRIPTION       = 'Description';
    const SC_PRODUCT_BRAND             = 'Brand';
    const SC_PRODUCT_PRICE             = 'Price';
    const SC_PRODUCT_SALE_PRICE        = 'SalePrice';
    const SC_PRODUCT_SALE_START_DATE   = 'SaleStartDate';
    const SC_PRODUCT_SALE_END_DATE     = 'SaleEndDate';
    const SC_PRODUCT_TAX_CLASS         = 'TaxClass';
    const SC_PRODUCT_SHIPMENT_TYPE     = 'ShipmentType';
    const SC_PRODUCT_ID                = 'ProductId';
    const SC_PRODUCT_CONDITION         = 'Condition';
    const SC_PRODUCT_DATA              = 'ProductData';
    const SC_PRODUCT_MAIN_MATERIAL     = 'MainMaterial';
    const SC_PRODUCT_COLOR             = 'Color';
    const SC_PRODUCT_WEIGHT            = 'ProductWeight';
    const SC_PRODUCT_DESCRIPTION_AR_EG = 'DescriptionArEG';
    const SC_PRODUCT_NAME_AR_EG        = 'NameArEG';
    const SC_PRODUCT_QUANTITY          = 'Quantity';
    const SC_PRODUCT_SHOP_SKU          = 'ShopSku';
    const SC_PRODUCT_FULLFILLMENT      = 'FulfillmentByNonSellable';
    const SC_PRODUCT_AVAILABLE         = 'Available';
    const SC_PRODUCT_URL               = 'Url';
    const SC_PRODUCT_MAIN_IMAGE        = 'MainImage';
    const SC_PRODUCT_MULTIPLE_IMAGES   = 'Images';
    const SC_PRODUCT_SINGLE_IMAGE      = 'Image' ;

    /** Max and Min cost of product to be pushed */
    const MAX_PRODUCT_COST_EGP = 25000;
    const MIN_PRODUCT_COST_EGP = 25;

    const MIN_PRICE_KEY = 'min';
    const MAX_PRICE_KEY = 'max';

    const DEFAULT_AVAILABLE = 5 ;
    const DEFAULT_NOT_AVAILABLE = 0 ;

    /** @var  string $sellerSku */
    protected $sellerSku;

    /** @var  string|null $parentSku */
    protected $parentSku;

    /** @var string $shopSku */
    protected $shopSku;

    /** @var  $price */
    protected $price;

    /** @var string $status */
    protected $status = self::SELLER_CENTER_PRODUCT_ACTIVE_STATUS;

    /** @var string $name */
    protected $name;

    /** @var  string $brand */
    protected $brand;

    /** @var string $primaryCategory */
    protected $primaryCategory;

    /** @var string|null $categories */
    protected $categories;

    /** @var  string $description */
    protected $description;

    /** @var  \DateTime $saleEndDate */
    protected $saleEndDate;

    /** @var  \DateTime $saleStartDate */
    protected $saleStartDate;

    /** @var  $salePrice */
    protected $salePrice;

    /** @var string $shipmentType */
    protected $shipmentType;

    /** @var  string $productId */
    protected $productId;

    /** @var  integer $quantity */
    protected $quantity = 100;

    /** @var  string $variation */
    protected $variation;

    /** @var array $images */
    protected $images;

    /** @var string|null $fulfillmentByNonSellable */
    protected $fulfillmentByNonSellable;

    /** @var string $url */
    protected $url;

    /** @var string $taxClass */
    protected $taxClass;

    /** @var string $condition */
    protected $condition;

    /** @var integer $volumetricWeight */
    protected $volumetricWeight;

    /** @var string $productGroup */
    protected $productGroup;

    /** @var integer $available */
    protected $available;

    /** @var string $mainImage */
    protected $mainImage;

    /** @var string|null $mainMaterial */
    protected $mainMaterial;

    /** @var float|null $productWeight */
    protected $productWeight;

    /** @var string|null $descriptionArEG */
    protected $descriptionArEG;

    /** @var string|null $nameArEG */
    protected $nameArEG;

    /** @var string|null $color */
    protected $color;

    /**
     * @return int
     */
    public function getAvailable(): int
    {
        return $this->available;
    }

    /**
     * @param int $available
     */
    public function setAvailable(int $available): void
    {
        $this->available = $available;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getCondition(): string
    {
        return $this->condition;
    }

    /**
     * @param string $condition
     */
    public function setCondition(string $condition): void
    {
        $this->condition = $condition;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getFulfillmentByNonSellable(): ?string
    {
        return $this->fulfillmentByNonSellable;
    }

    /**
     * @param string $fulfillmentByNonSellable|null
     */
    public function setFulfillmentByNonSellable(?string $fulfillmentByNonSellable): void
    {
        $this->fulfillmentByNonSellable = $fulfillmentByNonSellable;
    }

    /**
     * @return array|null
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     * @param null|array $images
     */
    public function setImages(?array $images): void
    {
        $this->images = $images;
    }

    /**
     * @return string
     */
    public function getMainImage(): string
    {
        return $this->mainImage;
    }

    /**
     * @param string $mainImage
     */
    public function setMainImage(string $mainImage): void
    {
        $this->mainImage = $mainImage;
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
     * @return string|null
     */
    public function getParentSku(): ?string
    {
        return $this->parentSku;
    }

    /**
     * @param null|string $parentSku
     */
    public function setParentSku(?string $parentSku): void
    {
        $this->parentSku = $parentSku;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getPrimaryCategory(): string
    {
        return $this->primaryCategory;
    }

    /**
     * @param string $primaryCategory
     */
    public function setPrimaryCategory(string $primaryCategory): void
    {
        $this->primaryCategory = $primaryCategory;
    }

    /**
     * @return string
     */
    public function getProductGroup(): string
    {
        return $this->productGroup;
    }

    /**
     * @param string $productGroup
     */
    public function setProductGroup(string $productGroup): void
    {
        $this->productGroup = $productGroup;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     */
    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return \DateTime
     */
    public function getSaleEndDate(): \DateTime
    {
        return $this->saleEndDate;
    }

    /**
     * @param \DateTime $saleEndDate
     */
    public function setSaleEndDate(\DateTime $saleEndDate): void
    {
        $this->saleEndDate = $saleEndDate;
    }

    /**
     * @return mixed
     */
    public function getSalePrice()
    {
        return $this->salePrice;
    }

    /**
     * @param mixed $salePrice
     */
    public function setSalePrice($salePrice): void
    {
        $this->salePrice = $salePrice;
    }

    /**
     * @return \DateTime
     */
    public function getSaleStartDate(): \DateTime
    {
        return $this->saleStartDate;
    }

    /**
     * @param \DateTime $saleStartDate
     */
    public function setSaleStartDate(\DateTime $saleStartDate): void
    {
        $this->saleStartDate = $saleStartDate;
    }

    /**
     * @return string
     */
    public function getSellerSku(): string
    {
        return $this->sellerSku;
    }

    /**
     * @param string $sellerSku
     */
    public function setSellerSku(string $sellerSku): void
    {
        $this->sellerSku = $sellerSku;
    }

    /**
     * @return string
     */
    public function getShipmentType(): string
    {
        return $this->shipmentType;
    }

    /**
     * @param string $shipmentType
     */
    public function setShipmentType(string $shipmentType): void
    {
        $this->shipmentType = $shipmentType;
    }

    /**
     * @return string
     */
    public function getShopSku(): string
    {
        return $this->shopSku;
    }

    /**
     * @param string $shopSku
     */
    public function setShopSku(string $shopSku): void
    {
        $this->shopSku = $shopSku;
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
    public function getTaxClass(): string
    {
        return $this->taxClass;
    }

    /**
     * @param string $taxClass
     */
    public function setTaxClass(string $taxClass): void
    {
        $this->taxClass = $taxClass;
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
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getVariation(): string
    {
        return $this->variation;
    }

    /**
     * @param string $variation
     */
    public function setVariation(string $variation): void
    {
        $this->variation = $variation;
    }

    /**
     * @return int
     */
    public function getVolumetricWeight(): int
    {
        return $this->volumetricWeight;
    }

    /**
     * @param int $volumetricWeight
     */
    public function setVolumetricWeight(int $volumetricWeight): void
    {
        $this->volumetricWeight = $volumetricWeight;
    }

    /**
     * @return string|null
     */
    public function getMainMaterial(): ?string
    {
        return $this->mainMaterial;
    }

    /**
     * @param string|null $mainMaterial
     */
    public function setMainMaterial(?string $mainMaterial): void
    {
        $this->mainMaterial = $mainMaterial;
    }

    /**
     * @return float|null
     */
    public function getProductWeight(): ?float
    {
        return $this->productWeight;
    }

    /**
     * @param float|null $productWeight
     */
    public function setProductWeight(?float $productWeight): void
    {
        $this->productWeight = $productWeight;
    }

    /**
     * @return string|null
     */
    public function getDescriptionArEG(): ?string
    {
        return $this->descriptionArEG;
    }

    /**
     * @param string|null $descriptionArEG
     */
    public function setDescriptionArEG(?string $descriptionArEG): void
    {
        $this->descriptionArEG = $descriptionArEG;
    }

    /**
     * @return string|null
     */
    public function getNameArEG(): ?string
    {
        return $this->nameArEG;
    }

    /**
     * @param string|null $nameArEG
     */
    public function setNameArEG(?string $nameArEG): void
    {
        $this->nameArEG = $nameArEG;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string|null $color
     */
    public function setColor(?string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return string|null
     */
    public function getCategories(): ?string
    {
        return $this->categories;
    }

    /**
     * @param string|null $categories
     */
    public function setCategories(?string $categories): void
    {
        $this->categories = $categories;
    }



}