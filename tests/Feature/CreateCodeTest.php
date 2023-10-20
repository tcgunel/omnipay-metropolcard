<?php

namespace Omnipay\MetropolCard\Tests\Feature;

use Omnipay\MetropolCard\Message\CreateCodeRequest;
use Omnipay\MetropolCard\Message\CreateCodeResponse;
use Omnipay\MetropolCard\Models\CreateCodeResponseModel;
use Omnipay\MetropolCard\Tests\TestCase;

class CreateCodeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_create_code_request(): void
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
            'amount'               => $this->faker->randomFloat(2, 1, 10000),
            'product_id'           => 1,
            'transactionReference' => $this->faker->uuid,
            'bearer_token'         => 'eyJhbGciOiJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGRzaWctbW9yZSNobWFjLXNoYTI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX25hbWUiOiJLT0ZURUPEsFlVU1VGVEVTVCIsInRhYmxlX3ByaW1hcnlfa2V5IjoiMTE2IiwiY29uc3VtZXJfaWQiOiIzNTc5MjMiLCJhcHBsaWNhdGlvbl9pZCI6IjIxIiwiUHJvY2Vzc0lkIjoiNTY0MDE4ZTMtOGYzYi00NGYzLWFkYTctNjFlY2E3MDZhMzI2IiwibmJmIjoxNjk3ODAzNzExLCJleHAiOjE2OTc4MDU1MTF9.x7AVTumPwNb5ida3M97Pxj9yjdFpqksx9tPUXbQD5Fs',
        ];

        $params_to_be_expected_back = [
            'MerchantCode'      => $params['merchant_code'],
            'TerminalCode'      => $params['terminal_code'],
            'TransactionAmount' => $params['amount'],
            'ProductId'         => $params['product_id'],
            'SaleRefCode'       => $params['transactionReference'],
        ];

        $request = new CreateCodeRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $data = $request->getData();

        self::assertEquals($data, $params_to_be_expected_back);
    }

    public function test_create_code_response(): void
    {
        $response_data = [
            'ResponseMessage' => 'Başarılı.',
            'ResponseCode'    => 0,
            'TransactionId'   => $this->faker->bothify('########'),
            'QRCode'          => $this->faker->bothify('####################'),
            'ShortCode'       => $this->faker->bothify('######'),
            'ExpireDate'      => '2021-03-25T09:26:25.5800901+03:00',
        ];

        $response = new CreateCodeResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertTrue($response->isSuccessful());

        $expected = new CreateCodeResponseModel([
            'ResponseMessage' => $response_data['ResponseMessage'],
            'ResponseCode'    => $response_data['ResponseCode'],
            'TransactionId'   => $response_data['TransactionId'],
            'QRCode'          => $response_data['QRCode'],
            'ShortCode'       => $response_data['ShortCode'],
            'ExpireDate'      => $response_data['ExpireDate'],
        ]);

        $this->assertEquals($expected, $data);
    }

    public function test_create_code_response_error(): void
    {
        $response_data = [
            'ResponseMessage' => 'Hata oluştu',
            'ResponseCode'    => 1478,
            'TransactionId'   => 0,
            'QRCode'          => null,
            'ShortCode'       => null,
            'ExpireDate'      => '0001-01-01T00:00:00',
        ];

        $response = new CreateCodeResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertFalse($response->isSuccessful());

        $expected = new CreateCodeResponseModel([
            'ResponseMessage' => $response_data['ResponseMessage'],
            'ResponseCode'    => $response_data['ResponseCode'],
            'TransactionId'   => $response_data['TransactionId'],
            'QRCode'          => $response_data['QRCode'],
            'ShortCode'       => $response_data['ShortCode'],
            'ExpireDate'      => $response_data['ExpireDate'],
        ]);

        $this->assertEquals($expected, $data);

        $this->assertEquals($expected, $data);
        $this->assertEquals($response_data['ResponseCode'], $response->getCode());
        $this->assertEquals($response_data['ResponseMessage'], $response->getMessage());
    }
}
