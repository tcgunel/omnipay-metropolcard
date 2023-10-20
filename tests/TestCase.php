<?php

namespace Omnipay\MetropolCard\Tests;

use Faker\Factory;
use Omnipay\MetropolCard\Gateway;
use Omnipay\Tests\GatewayTestCase;

class TestCase extends GatewayTestCase
{
	public $faker;

	public function setUp(): void
	{
		parent::setUp();

		$this->faker = Factory::create("tr_TR");

		$this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
	}
}
