<?php

namespace Omnipay\MetropolCard\Tests\Feature;

use Omnipay\MetropolCard\Constants\UserRefTypes;
use Omnipay\MetropolCard\Message\SaleWithOtpRequest;
use Omnipay\MetropolCard\Message\SaleWithOtpResponse;
use Omnipay\MetropolCard\Models\SaleWithOtpResponseModel;
use Omnipay\MetropolCard\Tests\TestCase;

class SaleWithOtpTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_sale_with_otp_request(): void
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
            'user_ref_no'          => $this->faker->bothify('################'),
            'user_ref_type'        => UserRefTypes::CARD_NO,
            'product_id'           => 1,
            'transactionReference' => $this->faker->uuid,
            'otp_ref_code'         => $this->faker->uuid,
            'otp'                  => $this->faker->bothify('#####'),
            'wallet_id'            => null,
            'branch_name'          => null,
            'bearer_token'         => 'eyJhbGciOiJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGRzaWctbW9yZSNobWFjLXNoYTI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX25hbWUiOiJLT0ZURUPEsFlVU1VGVEVTVCIsInRhYmxlX3ByaW1hcnlfa2V5IjoiMTE2IiwiY29uc3VtZXJfaWQiOiIzNTc5MjMiLCJhcHBsaWNhdGlvbl9pZCI6IjIxIiwiUHJvY2Vzc0lkIjoiNTY0MDE4ZTMtOGYzYi00NGYzLWFkYTctNjFlY2E3MDZhMzI2IiwibmJmIjoxNjk3ODAzNzExLCJleHAiOjE2OTc4MDU1MTF9.x7AVTumPwNb5ida3M97Pxj9yjdFpqksx9tPUXbQD5Fs',
        ];

        $params_to_be_expected_back = [
            'MerchantCode'      => $params['merchant_code'],
            'TerminalCode'      => $params['terminal_code'],
            'UserRefNo'         => $params['user_ref_no'],
            'UserRefType'       => $params['user_ref_type'],
            'ProductId'         => $params['product_id'],
            'TransactionAmount' => $params['amount'],
            'SaleRefCode'       => $params['transactionReference'],
            'OtpRefCode'        => $params['otp_ref_code'],
            'Otp'               => $params['otp'],
            'WalletId'          => $params['wallet_id'],
            'BranchName'        => $params['branch_name'],
        ];

        $request = new SaleWithOtpRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $data = $request->getData();

        self::assertEquals($data, $params_to_be_expected_back);
    }

    public function test_sale_with_otp_response(): void
    {
        $response_data = [
            'ResponseMessage'   => 'Harcama başarılı.',
            'ResponseCode'      => 0,
            'MerchantCode'      => $this->faker->bothify('##########'),
            'TerminalCode'      => $this->faker->bothify('##########'),
            'CardNo'            => $this->faker->bothify('###******###'),
            'SaleRefCode'       => $this->faker->uuid,
            'TransactionId'     => $this->faker->bothify('########'),
            'TransactionAmount' => $this->faker->randomFloat(2, 1, 1000),
            'BatchNo'           => 1,
            'Balance'           => $this->faker->randomFloat(2, 1, 1000),
            'CardOwner'         => $this->faker->name,
            'ProductName'       => $this->faker->name,
        ];

        $response = new SaleWithOtpResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertTrue($response->isSuccessful());

        $expected = new SaleWithOtpResponseModel($response_data);

        $this->assertEquals($expected, $data);
    }

    public function test_sale_with_otp_response_error(): void
    {
        $response_data = [
            'ResponseMessage'   => 'Süresi geçmiş istek.',
            'ResponseCode'      => 20222,
            'MerchantCode'      => null,
            'TerminalCode'      => null,
            'CardNo'            => null,
            'SaleRefCode'       => null,
            'TransactionId'     => 0,
            'TransactionAmount' => 0,
            'BatchNo'           => 0,
            'Balance'           => 0,
            'CardOwner'         => null,
            'ProductName'       => null,
        ];

        $response = new SaleWithOtpResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertFalse($response->isSuccessful());

        $expected = new SaleWithOtpResponseModel($response_data);

        $this->assertEquals($expected, $data);

        $this->assertEquals($expected, $data);
        $this->assertEquals($response_data['ResponseCode'], $response->getCode());
        $this->assertEquals($response_data['ResponseMessage'], $response->getMessage());
    }
}
