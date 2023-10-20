<?php

namespace Omnipay\MetropolCard\Models;

class RefundResponseModel extends BaseModel
{
    public int $ResponseCode;
    public string $ResponseMessage;
    public ?string $MerchantCode;
    public ?string $TerminalCode;
    public ?string $SaleRefCode;
    public ?int $TransactionId;
    public ?int $ReturnType;
}
