<?php

namespace Omnipay\MetropolCard\Models;

class CreateCodeResponseModel extends BaseModel
{
    public string $ResponseMessage;
    public int $ResponseCode;
    public int $TransactionId;
    public ?string $QRCode;
    public ?string $ShortCode;
    public string $ExpireDate;
}
