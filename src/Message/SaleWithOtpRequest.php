<?php

namespace Omnipay\MetropolCard\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\MetropolCard\Exceptions\CreateDateFromException;
use Omnipay\MetropolCard\Traits\HasParameters;

class SaleWithOtpRequest extends RemoteAbstractRequest
{
    use HasParameters;

    public array $endpoints = [
        'test' => 'https://testapi.metropolcard.com/vpos/v3/sale/salewithotp',
        'prod' => 'https://api.metropolcard.com/vpos/v3/sale/salewithotp'
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
            'user_ref_no',
            'user_ref_type',
            'product_id',
            'transactionReference',
            'otp_ref_code',
            'otp',
            'bearer_token',
        );

        return [
            "MerchantCode"      => $this->getMerchantCode(),
            "TerminalCode"      => $this->getTerminalCode(),
            "UserRefNo"         => $this->getUserRefNo(),
            "UserRefType"       => $this->getUserRefType(),
            "ProductId"         => $this->getProductId(),
            "WalletId"          => $this->getWalletId(),
            "TransactionAmount" => $this->getAmount(),
            "SaleRefCode"       => $this->getTransactionReference(),
            "OtpRefCode"        => $this->getOtpRefCode(),
            "Otp"               => $this->getOtp(),
            "BranchName"        => $this->getBranchName(),
        ];
    }

    /**
     * @throws \JsonException
     */
    public function sendData($data): SaleWithOtpResponse
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
    protected function createResponse($data): SaleWithOtpResponse
    {
        $this->response = new SaleWithOtpResponse($this, $data);

        return $this->response;
    }
}
