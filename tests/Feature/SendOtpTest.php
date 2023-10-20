<?php

namespace Omnipay\MetropolCard\Tests\Feature;

use Omnipay\MetropolCard\Constants\UserRefTypes;
use Omnipay\MetropolCard\Message\SendOtpRequest;
use Omnipay\MetropolCard\Message\SendOtpResponse;
use Omnipay\MetropolCard\Models\SendOtpResponseModel;
use Omnipay\MetropolCard\Tests\TestCase;

class SendOtpTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_send_otp_request(): void
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
            'amount'        => $this->faker->randomFloat(2, 1, 10000),
            'user_ref_no'   => $this->faker->bothify('################'),
            'user_ref_type' => UserRefTypes::CARD_NO,
            'bearer_token'  => 'eyJhbGciOiJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGRzaWctbW9yZSNobWFjLXNoYTI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX25hbWUiOiJLT0ZURUPEsFlVU1VGVEVTVCIsInRhYmxlX3ByaW1hcnlfa2V5IjoiMTE2IiwiY29uc3VtZXJfaWQiOiIzNTc5MjMiLCJhcHBsaWNhdGlvbl9pZCI6IjIxIiwiUHJvY2Vzc0lkIjoiNTY0MDE4ZTMtOGYzYi00NGYzLWFkYTctNjFlY2E3MDZhMzI2IiwibmJmIjoxNjk3ODAzNzExLCJleHAiOjE2OTc4MDU1MTF9.x7AVTumPwNb5ida3M97Pxj9yjdFpqksx9tPUXbQD5Fs',
        ];

        $params_to_be_expected_back = [
            'MerchantCode'      => $params['merchant_code'],
            'TerminalCode'      => $params['terminal_code'],
            'UserRefNo'         => $params['user_ref_no'],
            'UserRefType'       => $params['user_ref_type'],
            'TransactionAmount' => $params['amount'],
        ];

        $request = new SendOtpRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $data = $request->getData();

        self::assertEquals($data, $params_to_be_expected_back);
    }

    public function test_send_otp_response(): void
    {
        $response_data = [
            'ResponseMessage' => 'Harcama başarılı.',
            'ResponseCode'    => 0,
            'OtpRefCode'      => $this->faker->uuid,
        ];

        $response = new SendOtpResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertTrue($response->isSuccessful());

        $expected = new SendOtpResponseModel($response_data);

        $this->assertEquals($expected, $data);
    }

    public function test_send_otp_response_error(): void
    {
        $response_data = [
            'ResponseMessage' => 'Metropol kullanıcısı bulunamadı.',
            'ResponseCode'    => 20241,
            'OtpRefCode'      => null,
        ];

        $response = new SendOtpResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertFalse($response->isSuccessful());

        $expected = new SendOtpResponseModel($response_data);

        $this->assertEquals($expected, $data);

        $this->assertEquals($expected, $data);
        $this->assertEquals($response_data['ResponseCode'], $response->getCode());
        $this->assertEquals($response_data['ResponseMessage'], $response->getMessage());
    }
}
