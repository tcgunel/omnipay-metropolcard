[![License](https://poser.pugx.org/tcgunel/omnipay-metropolcard/license)](https://packagist.org/packages/tcgunel/omnipay-metropolcard)
[![Buy us a tree](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen)](https://plant.treeware.earth/tcgunel/omnipay-metropolcard)
[![PHP Composer](https://github.com/tcgunel/omnipay-metropolcard/actions/workflows/tests.yml/badge.svg)](https://github.com/tcgunel/omnipay-metropolcard/actions/workflows/tests.yml)

# Omnipay MetropolCard Gateway
Omnipay gateway for MetropolCard. All the methods of MetropolCard implemented for easy usage.

MetropolCard ile ödeme almaya yardımcı php class. 

## Requirements
| PHP       | Package |
|-----------|---------|
| ^7.4-^8.0 | v1.0.0  |

## Installment

```
composer require tcgunel/omnipay-metropolcard
```

## Usage

Please see the [Wiki](https://github.com/tcgunel/omnipay-metropolcard/wiki) page for detailed usage of every method.

## Methods

* generateToken() // Bearer token oluştur.
* createCode() // QR kod oluşturarak satış.
* querySaleInfo() // createCode ile oluşturulan satışın durumu.
* sendOtp() // Otp gönder.
* saleWithOtp() // Otp ile satış.
* usableWalletList() // Kullanıcı cüzdanları.
* refund() // İptal/İade.

## Tests
```
composer test
```
For windows:
```
vendor\bin\paratest.bat
```

## Treeware

This package is [Treeware](https://treeware.earth). If you use it in production, then we ask that you [**buy the world a tree**](https://plant.treeware.earth/tcgunel/omnipay-metropolcard) to thank us for our work. By contributing to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.
