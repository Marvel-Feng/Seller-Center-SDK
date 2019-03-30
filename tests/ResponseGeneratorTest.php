<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 17/01/19
 * Time: 11:37 ص
 */

namespace SellerCenter\tests;

use PHPUnit\Framework\TestCase;
use SellerCenter\Factory\ResponseGeneratorFactory;
use SellerCenter\Model\CategoryAttribute;
use SellerCenter\Model\FeedStatus;
use SellerCenter\Model\Order;
use SellerCenter\Model\OrderItem;
use SellerCenter\Model\Product;

class ResponseGeneratorTest extends TestCase
{
    /** @var ResponseGeneratorFactory $generatorFactory */
    private $generatorFactory;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct(
            $name,
            $data,
            $dataName
        );
        $this->generatorFactory = new ResponseGeneratorFactory();

    }


    /**
     *
     * @dataProvider getGeneratorTestCases
     *
     * @param string $responseType
     * @param array  $response
     *
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function testGeneratorMakeBody(string $responseType, array $response)
    {
        if ($responseType == 'invalid') {
            $this->expectException(\InvalidArgumentException::class);
            $this->generatorFactory->make($responseType);
        } else {
            $generator    = $this->generatorFactory->make($responseType);
            $class_name   = (new \ReflectionClass($generator))->getShortName();
            $bodyContents = $generator->makeResponse($response)
                ->getBody();
            switch ($class_name) {
                case 'ProductResponseGenerator':
                    $firstElement = current($bodyContents);
                    $this->assertInstanceOf(Product::class, $firstElement);
                    // @todo check if objects attributes equals data constructed
                    break;
                case 'FeedStatusResponseGenerator':
                    $this->assertInstanceOf(FeedStatus::class, $bodyContents);
                    break;
                case 'CategoryResponseGenerator':
                    $firstElement = current($bodyContents);
                    $this->assertInstanceOf(CategoryAttribute::class, $firstElement);
                    break;
                case 'OrderItemResponseGenerator':
                    $firstElement = current($bodyContents);
                    $this->assertInstanceOf(OrderItem::class, $firstElement);
                    break;
                case 'OrderResponseGenerator':
                    $firstElement = current($bodyContents);
                    $this->assertInstanceOf(Order::class, $firstElement);
                    break;
                default:
                    break;
            }
        }
    }


    public function getGeneratorTestCases()
    {
        $products   = json_decode(file_get_contents(__DIR__.'/HydratorTest/products.json'), true);
        $categories = json_decode(file_get_contents(__DIR__.'/HydratorTest/categories.json'), true);
        $feedStatus = json_decode(file_get_contents(__DIR__.'/HydratorTest/feed_status.json'), true);
        $orders     = json_decode(file_get_contents(__DIR__.'/HydratorTest/orders.json'), true);
        $orderItems = json_decode(file_get_contents(__DIR__.'/HydratorTest/orderItems.json'), true);

        return [
            [
                'Products',
                $products['test1'],
            ],
            [
                'Products',
                $products['test2'],
            ],
            [
                'FeedDetail',
                $feedStatus,
            ],
            [
                'Attributes',
                $categories['test1'],
            ],
            [
                'Attributes',
                $categories['test2'],
            ],
            [
                'Orders',
                $orders['test1'],
            ],
            [
                'Orders',
                $orders['test2'],
            ],
            [
                'Orders',
                $orders['test3'],
            ],
            [
               'OrderItems',
               $orderItems['test1']
            ],
            [
               'OrderItems',
               $orderItems['test2']
            ],
            [
                'invalid',
                [],
            ],
        ];
    }


}