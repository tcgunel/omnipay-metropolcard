<?php

namespace Omnipay\MetropolCard\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\MetropolCard\Exceptions\CreateDateFromException;
use Omnipay\MetropolCard\Traits\HasParameters;

class CreateCodeRequest extends RemoteAbstractRequest
{
    use HasParameters;

    public array $endpoints = [
        'test' => 'http://testapi.metropolcard.com/vpos/v2/sale/createcode',
        'prod' => 'http://api.metropolcard.com/vpos/v2/sale/createcode'
    ];

    /**
     * @throws InvalidRequestException|InvalidCreditCardException
     */
    public function getData(): array
    {
        $this->validate(
            'merchant_code',
            'terminal_code',
            'amount',
            'product_id',
            'transactionReference',
            'bearer_token',
        );

        return [
            "MerchantCode"      => $this->getMerchantCode(),
            "TerminalCode"      => $this->getTerminalCode(),
            "TransactionAmount" => $this->getAmount(),
            "ProductId"         => $this->getProductId(),
            "SaleRefCode"       => $this->getTransactionReference(),
        ];
    }

    /**
     * @throws \JsonException
     */
    public function sendData($data): CreateCodeResponse
    {
        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getTestMode() ? $this->endpoints['test'] : $this->endpoints['prod'],
            [
                'Authorization' => 'Bearer ' . $this->getBearerToken(),
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
            json_encode($data, JSON_THROW_ON_ERROR)
        );

        return $this->createResponse($httpResponse);
    }

    /**
     * @throws \JsonException
     */
    protected function createResponse($data): CreateCodeResponse
    {
        $this->response = new CreateCodeResponse($this, $data);

        return $this->response;
    }
}
