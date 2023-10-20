<?php

namespace Omnipay\MetropolCard\Tests\Feature;

use Omnipay\MetropolCard\Message\RefundRequest;
use Omnipay\MetropolCard\Message\RefundResponse;
use Omnipay\MetropolCard\Models\RefundResponseModel;
use Omnipay\MetropolCard\Tests\TestCase;

class RefundTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_refund_request(): void
    {
        $params = [
            'consumer_id'   => $this->faker->bothify('##########'),
            'consumer_name' => $this->faker->userName,
            'ref_no'        => $this->faker->randomNumber(5),
            'access_key'    => $this->faker->uuid,
            'aes_password'  => $this->faker->bothify('#?????????#????#'),
            'testMode'      => $this->faker->boolean(),

            'merchant_code'        => $this->faker->bothify('##########'),
            'terminal_code'        => $this->faker->bothify('##########'),
            'transactionReference' => $this->faker->uuid,
            'transactionId'        => $this->faker->bothify('##########'),
            'amount'               => $this->faker->randomFloat(2, 1, 10000),
            'refund_amount'        => $this->faker->randomFloat(2, 1, 10000),
            'bearer_token'         => 'eyJhbGciOiJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGRzaWctbW9yZSNobWFjLXNoYTI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX25hbWUiOiJLT0ZURUPEsFlVU1VGVEVTVCIsInRhYmxlX3ByaW1hcnlfa2V5IjoiMTE2IiwiY29uc3VtZXJfaWQiOiIzNTc5MjMiLCJhcHBsaWNhdGlvbl9pZCI6IjIxIiwiUHJvY2Vzc0lkIjoiNTY0MDE4ZTMtOGYzYi00NGYzLWFkYTctNjFlY2E3MDZhMzI2IiwibmJmIjoxNjk3ODAzNzExLCJleHAiOjE2OTc4MDU1MTF9.x7AVTumPwNb5ida3M97Pxj9yjdFpqksx9tPUXbQD5Fs',
        ];

        $params_to_be_expected_back = [
            'MerchantCode'      => $params['merchant_code'],
            'TerminalCode'      => $params['terminal_code'],
            'SaleRefCode'       => $params['transactionReference'],
            'TransactionId'     => $params['transactionId'],
            'TransactionAmount' => $params['amount'],
            'ReturnAmount'      => $params['refund_amount'],
        ];

        $request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $data = $request->getData();

        self::assertEquals($data, $params_to_be_expected_back);
    }

    public function test_refund_response(): void
    {
        $response_data = [
            'ResponseMessage' => 'İade işlemi başarılı bir şekilde gerçekleştirilmiştir.',
            'ResponseCode'    => 0,
            'MerchantCode'    => $this->faker->bothify('##########'),
            'TerminalCode'    => $this->faker->bothify('##########'),
            'SaleRefCode'     => $this->faker->uuid,
            'TransactionId'   => $this->faker->bothify('##########'),
            'ReturnType'      => 2,
        ];

        $response = new RefundResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertTrue($response->isSuccessful());

        $expected = new RefundResponseModel($response_data);

        $this->assertEquals($expected, $data);

        $this->assertEquals($expected, $data);
        $this->assertEquals($response_data['ResponseCode'], $response->getCode());
        $this->assertEquals($response_data['ResponseMessage'], $response->getMessage());
    }

    public function test_refund_response_error(): void
    {
        $response_data = [
            'ResponseMessage' => 'İade yapilamaz. İade tutari iade edilebilecek tutardan buyuk olamaz.',
            'ResponseCode'    => 502,
            'MerchantCode'    => null,
            'TerminalCode'    => null,
            'SaleRefCode'   => uniqid(),
            'TransactionId'   => 0,
            'ReturnType'          => 2,
        ];

        $response = new RefundResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertFalse($response->isSuccessful());

        $expected = new RefundResponseModel($response_data);

        $this->assertEquals($expected, $data);

        $this->assertEquals($expected, $data);
        $this->assertEquals($response_data['ResponseCode'], $response->getCode());
        $this->assertEquals($response_data['ResponseMessage'], $response->getMessage());
    }
}
