<?php

namespace Omnipay\MetropolCard\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\MetropolCard\Exceptions\CreateDateFromException;
use Omnipay\MetropolCard\Traits\HasParameters;

class GenerateTokenRequest extends RemoteAbstractRequest
{
    use HasParameters;

    public array $endpoints = [
        'test' => 'https://testAuth.metropolodeme.com/GenerateToken',
        'prod' => 'https://auth.metropolodeme.com/GenerateToken'
    ];

    public array $date_endpoints = [
        'test' => 'https://testauth.metropolodeme.com/GenerateToken/getdate',
        'prod' => 'https://auth.metropolodeme.com/GenerateToken/getdate'
    ];

    /**
     * @throws InvalidRequestException|InvalidCreditCardException
     */
    public function getData(): array
    {
        $this->validate(
            'consumer_id',
            'consumer_name',
            'ref_no',
            'access_key',
            'aes_password',
        );

        return [
            "ConsumerId"       => $this->getConsumerId(),
            "ConsumerName"     => $this->getConsumerName(),
            "SecureAccessData" => $this->generateSecureAccessData(),
            "RefNo"            => $this->getRefNo(),
        ];
    }

    /**
     * @throws \JsonException
     * @throws CreateDateFromException
     */
    private function generateSecureAccessData()
    {
        $data = json_encode([
            'AccessKey'  => $this->getAccessKey(),
            'CreateDate' => $this->getCreateDateFromServer(),
        ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        $method = 'AES-128-CBC';

        return @openssl_encrypt($data, $method, $this->getAesPassword());
    }

    private function getCreateDateFromServer(): string
    {
        $httpResponse = $this->httpClient->request(
            'GET',
            $this->getTestMode() ? $this->date_endpoints['test'] : $this->date_endpoints['prod'],
            [
                'Content-Type' => 'application/json',
            ],
        );

        if ($httpResponse->getStatusCode() !== 200) {

            throw new CreateDateFromException('MetropolCard sunucusundan tarih ve saat alırken hata oluştu.');

        }

        return (string)$httpResponse->getBody();
    }

    /**
     * @throws \JsonException
     */
    public function sendData($data): GenerateTokenResponse
    {
        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getTestMode() ? $this->endpoints['test'] : $this->endpoints['prod'],
            [
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
    protected function createResponse($data): GenerateTokenResponse
    {
        $this->response = new GenerateTokenResponse($this, $data);

        return $this->response;
    }
}
