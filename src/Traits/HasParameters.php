<?php

namespace Omnipay\MetropolCard\Traits;

trait HasParameters
{
    public function getConsumerId()
    {
        return $this->getParameter('consumer_id');
    }

    public function setConsumerId($value)
    {
        return $this->setParameter('consumer_id', $value);
    }

    public function getConsumerName()
    {
        return $this->getParameter('consumer_name');
    }

    public function setConsumerName($value)
    {
        return $this->setParameter('consumer_name', $value);
    }

    public function getRefNo()
    {
        return $this->getParameter('ref_no');
    }

    public function setRefNo($value)
    {
        return $this->setParameter('ref_no', $value);
    }

    public function getAccessKey()
    {
        return $this->getParameter('access_key');
    }

    public function setAccessKey($value)
    {
        return $this->setParameter('access_key', $value);
    }

    public function getAesPassword()
    {
        return $this->getParameter('aes_password');
    }

    public function setAesPassword($value)
    {
        return $this->setParameter('aes_password', $value);
    }

    public function getBearerToken()
    {
        return $this->getParameter('bearer_token');
    }

    public function setBearerToken($value)
    {
        return $this->setParameter('bearer_token', $value);
    }

    public function getMerchantCode()
    {
        return $this->getParameter('merchant_code');
    }

    public function setMerchantCode($value)
    {
        return $this->setParameter('merchant_code', $value);
    }

    public function getTerminalCode()
    {
        return $this->getParameter('terminal_code');
    }

    public function setTerminalCode($value)
    {
        return $this->setParameter('terminal_code', $value);
    }

    public function getProductId()
    {
        return $this->getParameter('product_id');
    }

    public function setProductId($value)
    {
        return $this->setParameter('product_id', $value);
    }

    public function getUserRefNo()
    {
        return $this->getParameter('user_ref_no');
    }

    public function setUserRefNo($value)
    {
        $value = preg_replace('/\D/', '', $value);

        return $this->setParameter('user_ref_no', $value);
    }

    public function getUserRefType()
    {
        return $this->getParameter('user_ref_type');
    }

    public function setUserRefType($value)
    {
        return $this->setParameter('user_ref_type', $value);
    }

    public function getOtpRefCode()
    {
        return $this->getParameter('otp_ref_code');
    }

    public function setOtpRefCode($value)
    {
        return $this->setParameter('otp_ref_code', $value);
    }

    public function getOtp()
    {
        return $this->getParameter('otp');
    }

    public function setOtp($value)
    {
        return $this->setParameter('otp', $value);
    }

    public function getBranchName()
    {
        return $this->getParameter('branch_name');
    }

    public function setBranchName($value)
    {
        return $this->setParameter('branch_name', $value);
    }

    public function getWalletId()
    {
        return $this->getParameter('wallet_id');
    }

    public function setWalletId($value)
    {
        return $this->setParameter('wallet_id', $value);
    }

    public function getCardNo()
    {
        return $this->getParameter('card_no');
    }

    public function setCardNo($value)
    {
        $value = preg_replace('/\D/', '', $value);

        return $this->setParameter('card_no', $value);
    }

    public function getRefundAmount()
    {
        return $this->getParameter('refund_amount');
    }

    public function setRefundAmount($value)
    {
        return $this->setParameter('refund_amount', $value);
    }
}
