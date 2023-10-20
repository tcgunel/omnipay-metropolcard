<?php

namespace Omnipay\MetropolCard\Models;

class QuerySaleInfoResponseModel extends BaseModel
{
    public int $ResponseCode;
    public string $ResponseMessage;
    public ?string $ErrorMessage;

    public int $TransactionId;
    public float $TransactionAmount;

    public ?QuerySaleInfoCardHolderModel $CardHolder;
}

class QuerySaleInfoCardHolderModel extends BaseModel
{
    public ?string $Name;
    public ?string $Surname;
    public ?string $CardNo;
    public float $CardBalance;
}
