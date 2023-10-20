<?php

namespace Omnipay\MetropolCard\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\MetropolCard\Traits\HasParameters;

class QuerySaleInfoRequest extends RemoteAbstractRequest
{
    use HasParameters;

    public array $endpoints = [
        'test' => 'https://testapi.metropolcard.com/vpos/v2/sale/querysaleinfo',
        'prod' => 'https://api.metropolcard.com/vpos/v2/sale/querysaleinfo'
    ];

    /**
     * @throws InvalidRequestException|InvalidCreditCardException
     */
    public function getData(): array
    {
        $this->validate(
            'merchant_code',
            'terminal_code',
            'transactionId',
        );

        return [
            "MerchantCode"  => $this->getMerchantCode(),
            "TerminalCode"  => $this->getTerminalCode(),
            "TransactionId" => $this->getTransactionId(),
        ];
    }

    /**
     * @throws \JsonException
     */
    public function sendData($data): QuerySaleInfoResponse
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
    protected function createResponse($data): QuerySaleInfoResponse
    {
        $this->response = new QuerySaleInfoResponse($this, $data);

        return $this->response;
    }
}
