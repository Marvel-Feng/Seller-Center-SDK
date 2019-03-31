# Seller Center PHP SDK


[![Build Status][ico-travis]][link-travis]
[![codecov](https://codecov.io/gh/omarfawzi/Seller-Center-SDK/branch/master/graph/badge.svg)](https://codecov.io/gh/omarfawzi/Seller-Center-SDK)
[![Software License][ico-license]](LICENSE.md)
[![Latest Stable Version](https://poser.pugx.org/edfa3ly-backend/seller-center-sdk/v/stable)](https://packagist.org/packages/edfa3ly-backend/seller-center-sdk)
[![Total Downloads](https://poser.pugx.org/edfa3ly-backend/seller-center-sdk/downloads)](https://packagist.org/packages/edfa3ly-backend/seller-center-sdk)

## Install

Via Composer

``` bash
$ composer require edfa3ly-backend/seller-center-sdk
```

## Seller Center Docs 

https://sellerapi.sellercenter.net/docs

## Available Actions
* **Category Attributes** 
    * `getCategoryAttributes`
* **Feed**
    * `getFeedStatus`
* **Order**
    * `cancelOrder`
    * `getMultipleOrderItems`
    * `getMultipleOrdersWithOrderItems`
    * `getOrder`
    * `getOrderItems`
    * `getOrderWithOrderItems`
    * `getOrders`
    * `setOrderStatusToDelivered`
    * `setOrderStatusToFailedDelivery`
    * `setOrderStatusToReadyToShip`
    * `setOrderStatusToShipped`
* **Product**
    * `createProducts`
    * `getProducts`
    * `updateProducts`
* **Product Image**
    * `createImages`


## Usage

```
class Example
{  
    public function index() {
        $configuration = new Configuration('https://sellercenter-api.x.com.y','email@example.com','apiKey','apiPassword','username','v1');
        $configuration->setMinAttemptsDelay(1);  // in seconds default : 1
        $configuration->setMaxAttemptsDelay(10);  // in seconds default : 5
        $configuration->setRequestAttemptsThreshold(15) ; // number of failure retries default : 10  
        $productService = new ProductService();
        $products = $productService->getProducts($configuration,[]);
    }
}
```
## Logging Support 

Set Configuration to enable logging
```
 $configuration->setLoggingEnabled(true);
```

## How to test
``` bash
$ make test
```

## Security

If you discover any security related issues, please email omarfawzi96@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://travis-ci.com/omarfawzi/Seller-Center-SDK.svg?branch=master

[link-travis]: https://travis-ci.com/omarfawzi/Seller-Center-SDK
