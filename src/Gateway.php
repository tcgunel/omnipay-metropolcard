<?php

namespace Omnipay\MetropolCard;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MetropolCard\Traits\HasParameters;

/**
 * MetropolCard Gateway
 * (c) Tolga Can Günel
 * 2015, mobius.studio
 * http://www.github.com/tcgunel/omnipay-metropolcard
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = [])
 */
class Gateway extends AbstractGateway
{
    use HasParameters;

    public function getName(): string
    {
        return 'MetropolCard';
    }

    public function getDefaultParameters()
    {
        return [
        ];
    }

    public function generateToken(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\MetropolCard\Message\GenerateTokenRequest', $parameters);
    }

    public function createCode(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\MetropolCard\Message\CreateCodeRequest', $parameters);
    }

    public function querySaleInfo(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\MetropolCard\Message\QuerySaleInfoRequest', $parameters);
    }

    public function sendOtp(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\MetropolCard\Message\SendOtpRequest', $parameters);
    }

    public function saleWithOtp(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\MetropolCard\Message\SaleWithOtpRequest', $parameters);
    }

    public function usableWalletList(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\MetropolCard\Message\UsableWalletListRequest', $parameters);
    }

    public function refund(array $parameters = array()): AbstractRequest
    {
      return $this->createRequest('\Omnipay\MetropolCard\Message\RefundRequest', $parameters);
    }
}
