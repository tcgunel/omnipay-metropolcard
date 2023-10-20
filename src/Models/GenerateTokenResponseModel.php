<?php

namespace Omnipay\MetropolCard\Models;

class GenerateTokenResponseModel extends BaseModel
{
    public bool $success;
    public string $responseMessage;
    public int $responseCode;
    public ?GenerateTokenDataModel $data;
}

class GenerateTokenDataModel extends BaseModel
{
    public string $token;
    public string $expiration;
}
