<?php

namespace Omnipay\MetropolCard\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MetropolCard\Traits\HasParameters;

abstract class RemoteAbstractRequest extends AbstractRequest
{
    use HasParameters;

    abstract protected function createResponse($data);
}
