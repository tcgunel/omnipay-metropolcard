<?php

namespace Omnipay\MetropolCard\Message;

use Omnipay\MetropolCard\Models\CreateCodeResponseModel;

class CreateCodeResponse extends RemoteAbstractResponse
{
    /**
     * @throws \JsonException
     */
    public function __construct($request, $data)
	{
		parent::__construct($request, $data);

		$this->response = new CreateCodeResponseModel((array)$this->response);
	}

	public function isSuccessful(): bool
	{
        return $this->response->ResponseCode === 0;
	}

	public function getMessage(): string
	{
		return $this->response->ResponseMessage;
	}

    public function getCode()
    {
        return $this->response->ResponseCode;
    }

    public function getData(): CreateCodeResponseModel
	{
		return $this->response;
	}
}
