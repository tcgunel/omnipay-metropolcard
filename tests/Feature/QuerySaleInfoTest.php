<?php

namespace Omnipay\MetropolCard\Tests\Feature;

use Omnipay\MetropolCard\Message\QuerySaleInfoRequest;
use Omnipay\MetropolCard\Message\QuerySaleInfoResponse;
use Omnipay\MetropolCard\Models\QuerySaleInfoResponseModel;
use Omnipay\MetropolCard\Tests\TestCase;

class QuerySaleInfoTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_query_sale_info_request(): void
    {
        $params = [
            'consumer_id'   => $this->faker->bothify('##########'),
            'consumer_name' => $this->faker->userName,
            'ref_no'        => $this->faker->randomNumber(5),
            'access_key'    => $this->faker->uuid,
            'aes_password'  => $this->faker->bothify('#?????????#????#'),
            'testMode'      => $this->faker->boolean(),

            'merchant_code' => $this->faker->bothify('##########'),
            'terminal_code' => $this->faker->bothify('##########'),
            'transactionId' => $this->faker->bothify('##########'),
            'bearer_token'  => 'eyJhbGciOiJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGRzaWctbW9yZSNobWFjLXNoYTI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX25hbWUiOiJLT0ZURUPEsFlVU1VGVEVTVCIsInRhYmxlX3ByaW1hcnlfa2V5IjoiMTE2IiwiY29uc3VtZXJfaWQiOiIzNTc5MjMiLCJhcHBsaWNhdGlvbl9pZCI6IjIxIiwiUHJvY2Vzc0lkIjoiNTY0MDE4ZTMtOGYzYi00NGYzLWFkYTctNjFlY2E3MDZhMzI2IiwibmJmIjoxNjk3ODAzNzExLCJleHAiOjE2OTc4MDU1MTF9.x7AVTumPwNb5ida3M97Pxj9yjdFpqksx9tPUXbQD5Fs',
        ];

        $params_to_be_expected_back = [
            'MerchantCode'  => $params['merchant_code'],
            'TerminalCode'  => $params['terminal_code'],
            'TransactionId' => $params['transactionId'],
        ];

        $request = new QuerySaleInfoRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $data = $request->getData();

        self::assertEquals($data, $params_to_be_expected_back);
    }

    public function test_query_sale_info_response(): void
    {
        $response_data = [
            'ResponseMessage'   => 'HARCAMA İŞLEMİ BAŞARILI.',
            'ResponseCode'      => 0,
            'TransactionId'     => $this->faker->bothify('########'),
            'TransactionAmount' => $this->faker->randomFloat(2, 1, 1000),
            'CardHolder'        => [
                'Name'        => $this->faker->firstName,
                'Surname'     => $this->faker->lastName,
                'CardNo'      => $this->faker->bothify('###**###'),
                'CardBalance' => $this->faker->randomFloat(2, 1, 1000),
            ],
        ];

        $response = new QuerySaleInfoResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertTrue($response->isSuccessful());

        $expected = new QuerySaleInfoResponseModel($response_data);

        $this->assertEquals($expected, $data);
    }

    public function test_query_sale_info_response_error(): void
    {
        $response_data = [
            'ResponseMessage'   => 'Süresi geçmiş QR kod.',
            'ResponseCode'      => 7601,
            'TransactionId'     => 0,
            'TransactionAmount' => 0,
            'CardHolder'        => [
                'Name'        => null,
                'Surname'     => null,
                'CardNo'      => null,
                'CardBalance' => 0,
            ],
        ];

        $response = new QuerySaleInfoResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertFalse($response->isSuccessful());

        $expected = new QuerySaleInfoResponseModel($response_data);

        $this->assertEquals($expected, $data);

        $this->assertEquals($expected, $data);
        $this->assertEquals($response_data['ResponseCode'], $response->getCode());
        $this->assertEquals($response_data['ResponseMessage'], $response->getMessage());
    }
}
