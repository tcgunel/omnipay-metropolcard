<?php

namespace Omnipay\MetropolCard\Models;

class SendOtpResponseModel extends BaseModel
{
    public string $ResponseMessage;
    public int $ResponseCode;
    public ?string $OtpRefCode;
}
