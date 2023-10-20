<?php

namespace Omnipay\MetropolCard\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\MetropolCard\Traits\HasParameters;

class RefundRequest extends RemoteAbstractRequest
{
    use HasParameters;

    public array $endpoints = [
        'test' => 'https://testapi.metropolcard.com/vpos/v2/sale/return',
        'prod' => 'https://api.metropolcard.com/vpos/v2/sale/return'
    ];

    /**
     * @throws InvalidRequestException|InvalidCreditCardException
     */
    public function getData(): array
    {
        $this->validate(
            'merchant_code',
            'terminal_code',
            'transactionReference',
            'transactionId',
            'amount',
            'refund_amount',
            'bearer_token',
        );

        return [
            "MerchantCode"      => $this->getMerchantCode(),
            "TerminalCode"      => $this->getTerminalCode(),
            "SaleRefCode"       => $this->getTransactionReference(),
            "TransactionId"     => $this->getTransactionId(),
            "TransactionAmount" => $this->getAmount(),
            "ReturnAmount"      => $this->getRefundAmount(),
        ];
    }

    /**
     * @throws \JsonException
     */
    public function sendData($data): RefundResponse
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
    protected function createResponse($data): RefundResponse
    {
        $this->response = new RefundResponse($this, $data);

        return $this->response;
    }
}
