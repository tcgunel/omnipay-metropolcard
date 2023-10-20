<?php

namespace Omnipay\MetropolCard\Models;

class SaleWithOtpResponseModel extends BaseModel
{
    public string $ResponseMessage;
    public int $ResponseCode;
    public ?string $MerchantCode;
    public ?string $TerminalCode;
    public ?string $CardNo;
    public ?string $SaleRefCode;
    public ?int $TransactionId;
    public ?float $TransactionAmount;
    public ?int $BatchNo;
    public ?float $Balance;
    public ?string $CardOwner;
    public ?string $ProductName;
}
