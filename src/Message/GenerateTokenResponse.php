<?php

namespace Omnipay\MetropolCard\Message;

use Omnipay\MetropolCard\Models\GenerateTokenResponseModel;

class GenerateTokenResponse extends RemoteAbstractResponse
{
    /**
     * @throws \JsonException
     */
    public function __construct($request, $data)
	{
		parent::__construct($request, $data);

		$this->response = new GenerateTokenResponseModel((array)$this->response);
	}

	public function isSuccessful(): bool
	{
        return $this->response->success === true;
	}

	public function getMessage(): ?string
	{
		return $this->response->responseMessage;
	}

    public function getCode()
    {
        return $this->response->responseCode;
    }

    public function getData(): GenerateTokenResponseModel
	{
		return $this->response;
	}
}
