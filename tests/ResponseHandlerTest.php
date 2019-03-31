<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 21/01/19
 * Time: 12:13 م
 */

namespace SellerCenter\tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use SellerCenter\Handler\ResponseHandler;
use SellerCenter\Model\SuccessResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseHandlerTest extends TestCase
{
    /** @var ResponseHandler $responseHandler */
    private $responseHandler;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct(
            $name,
            $data,
            $dataName
        );
        $this->responseHandler = new ResponseHandler();
    }

    /** @dataProvider getGenerateResponseTestCases
     * @param array $response
     *
     * @throws \Exception
     */
    public function testGenerateSellerCenterSuccessResponse(array $response)
    {
        $successResponse = $this->responseHandler->generateSellerCenterSuccessResponse($response);
        $this->assertInstanceOf(SuccessResponse::class, $successResponse);
    }

    /**
     * @param string $responseFormat
     *
     * @param string $responseBody
     * @param bool   $true
     *
     * @param int    $statusCode
     *
     * @dataProvider getIsSuccessResponseTestCases
     */
    public function testIsSuccessResponse(string $responseFormat , string $responseBody, bool $true , int $statusCode = Response::HTTP_OK)
    {
        $responseMock = m::mock(ResponseInterface::class)
            ->allows('getHeaders')
            ->andReturn(
                [
                    'Content-Type' => [
                        0 => $responseFormat,
                    ],
                ]
            )
            ->getMock()
            ->allows('getStatusCode')
            ->andReturn($statusCode)
            ->getMock();
        $response = $this->responseHandler->isSuccessResponse($responseMock,$responseBody);
        $this->assertEquals($true,$response);
    }

    public function getGenerateResponseTestCases()
    {
        $products = json_decode(file_get_contents(__DIR__.'/HydratorTest/products.json'), true);

        return [
            [
                $products['test1'],
            ],
            [
                $products['test2'],
            ],
        ];
    }

    public function getIsSuccessResponseTestCases()
    {
        return [
            [
                'application/json',
                '{"SuccessResponse":"yes"}',
                true
            ],
            [
                'application/json',
                '{"ErrorResponse":"yes"}',
                false
            ],
            [
                'application/xml',
                '<SuccessResponse> 
                    <Head>
                        <RequestId/>
                        <RequestAction>GetProducts</RequestAction>
                        <ResponseType>Products</ResponseType>
                        <Timestamp>2015-07-01T11:11:11+0000</Timestamp>
                    </Head>
                </SuccessResponse>',
                true
            ],
            [
                'text/xml; charset=utf-8',
                '<ErrorResponse>
                </ErrorResponse>',
                false
            ],
            [
                'else',
                '',
                true
            ],
            [
                'else',
                '',
                false,
                Response::HTTP_BAD_REQUEST
            ]
        ];
    }


}