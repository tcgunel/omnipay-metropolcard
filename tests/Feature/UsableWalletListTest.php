<?php

namespace Omnipay\MetropolCard\Tests\Feature;

use Omnipay\MetropolCard\Constants\UserRefTypes;
use Omnipay\MetropolCard\Message\UsableWalletListRequest;
use Omnipay\MetropolCard\Message\UsableWalletListResponse;
use Omnipay\MetropolCard\Models\UsableWalletListResponseModel;
use Omnipay\MetropolCard\Tests\TestCase;

class UsableWalletListTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_usable_wallet_list_request(): void
    {
        $params = [
            'consumer_id'   => $this->faker->bothify('##########'),
            'consumer_name' => $this->faker->userName,
            'ref_no'        => $this->faker->randomNumber(5),
            'access_key'    => $this->faker->uuid,
            'aes_password'  => $this->faker->bothify('#?????????#????#'),
            'testMode'      => $this->faker->boolean(),

            'merchant_code' => $this->faker->bothify('##########'),
            'card_no'       => $this->faker->bothify('################'),
            'bearer_token'  => 'eyJhbGciOiJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGRzaWctbW9yZSNobWFjLXNoYTI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX25hbWUiOiJLT0ZURUPEsFlVU1VGVEVTVCIsInRhYmxlX3ByaW1hcnlfa2V5IjoiMTE2IiwiY29uc3VtZXJfaWQiOiIzNTc5MjMiLCJhcHBsaWNhdGlvbl9pZCI6IjIxIiwiUHJvY2Vzc0lkIjoiNTY0MDE4ZTMtOGYzYi00NGYzLWFkYTctNjFlY2E3MDZhMzI2IiwibmJmIjoxNjk3ODAzNzExLCJleHAiOjE2OTc4MDU1MTF9.x7AVTumPwNb5ida3M97Pxj9yjdFpqksx9tPUXbQD5Fs',
        ];

        $params_to_be_expected_back = [
            'MerchantCode' => $params['merchant_code'],
            'CardNo'       => $params['card_no'],
        ];

        $request = new UsableWalletListRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $data = $request->getData();

        self::assertEquals($data, $params_to_be_expected_back);
    }

    public function test_usable_wallet_list_response(): void
    {
        $response_data = [
            'ResponseMessage' => 'Cüzdan bilgileri gönderildi',
            'ResponseCode'    => 0,
            'Wallets'         => [
                [
                    'WalletId'    => $this->faker->numberBetween(1, 20),
                    'WalletName'  => $this->faker->name,
                    'ProductId'   => 1,
                    'ProductName' => $this->faker->name,
                    'VatRatio'    => 10,
                ],
                [
                    'WalletId'    => $this->faker->numberBetween(1, 20),
                    'WalletName'  => $this->faker->name,
                    'ProductId'   => 1,
                    'ProductName' => $this->faker->name,
                    'VatRatio'    => 10,
                ],
            ],
        ];

        $response = new UsableWalletListResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertTrue($response->isSuccessful());

        $expected = new UsableWalletListResponseModel($response_data);

        $this->assertEquals($expected, $data);
    }

    public function test_usable_wallet_list_response_error(): void
    {
        $response_data = [
            'ResponseMessage' => 'Ürüne ait kullanılabilir cüzdan bulunamadı',
            'ResponseCode'    => 98764,
        ];

        $response = new UsableWalletListResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertFalse($response->isSuccessful());

        $expected = new UsableWalletListResponseModel($response_data);

        $this->assertEquals($expected, $data);

        $this->assertEquals($expected, $data);
        $this->assertEquals($response_data['ResponseCode'], $response->getCode());
        $this->assertEquals($response_data['ResponseMessage'], $response->getMessage());
    }
}
