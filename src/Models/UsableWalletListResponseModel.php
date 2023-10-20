<?php

namespace Omnipay\MetropolCard\Models;

class UsableWalletListResponseModel extends BaseModel
{
    public string $ResponseMessage;
    public int $ResponseCode;
    public ?string $ErrorMessage;

    /** @var array|null|WalletModel[]  */
    public ?array $Wallets;
}

class WalletModel extends BaseModel
{
    public int $WalletId;
    public string $WalletName;
    public int $ProductId;
    public string $ProductName;
    public float $VatRatio;
}
