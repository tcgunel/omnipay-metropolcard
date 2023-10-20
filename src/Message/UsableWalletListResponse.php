<?php

namespace Omnipay\MetropolCard\Message;

use Omnipay\MetropolCard\Models\UsableWalletListResponseModel;

class UsableWalletListResponse extends RemoteAbstractResponse
{
    /**
     * @throws \JsonException
     */
    public function __construct($request, $data)
	{
		parent::__construct($request, $data);

		$this->response = new UsableWalletListResponseModel((array)$this->response);
	}

	public function isSuccessful(): bool
	{
        return $this->response->ResponseCode === 0;
	}

	public function getMessage(): string
	{
		return $this->response->ResponseMessage ?? $this->response->ErrorMessage;
	}

    public function getCode()
    {
        return $this->response->ResponseCode;
    }

    public function getData(): UsableWalletListResponseModel
	{
		return $this->response;
	}
}
