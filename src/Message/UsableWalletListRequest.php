<?php

namespace Omnipay\MetropolCard\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\MetropolCard\Exceptions\CreateDateFromException;
use Omnipay\MetropolCard\Traits\HasParameters;

class UsableWalletListRequest extends RemoteAbstractRequest
{
    use HasParameters;

    public array $endpoints = [
        'test' => 'https://testapi.metropolcard.com/vpos/v2/account/usablewalletlist',
        'prod' => 'https://api.metropolcard.com/vpos/v2/account/usablewalletlist'
    ];

    /**
     * @throws InvalidRequestException|InvalidCreditCardException
     */
    public function getData(): array
    {
        $this->validate(
            'merchant_code',
            'bearer_token',
        );

        return [
            "MerchantCode" => $this->getMerchantCode(),
            "CardNo"       => $this->getCardNo(),
        ];
    }

    /**
     * @throws \JsonException
     */
    public function sendData($data): UsableWalletListResponse
    {
        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getTestMode() ? $this->endpoints['test'] : $this->endpoints['prod'],
            [
                'Authorization' => 'Bearer ' . $this->getBearerToken(),
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ],
            json_encode($data, JSON_THROW_ON_ERROR)
        );

        return $this->createResponse($httpResponse);
    }

    /**
     * @throws \JsonException
     */
    protected function createResponse($data): UsableWalletListResponse
    {
        $this->response = new UsableWalletListResponse($this, $data);

        return $this->response;
    }
}
