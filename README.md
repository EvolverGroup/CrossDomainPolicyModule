# CrossDomainPolicyModule

Zend Framework 2 Module to provide cross-domain policy files

[![Packagist](https://img.shields.io/packagist/v/evolver/cross-domain-policy-module.svg)](https://packagist.org/packages/evolver/cross-domain-policy-module)
[![Downloads](https://img.shields.io/packagist/dt/evolver/cross-domain-policy-module.svg)](https://packagist.org/packages/evolver/cross-domain-policy-module)
[![License](https://img.shields.io/packagist/l/evolver/cross-domain-policy-module.svg)](https://packagist.org/packages/evolver/cross-domain-policy-module)
[![Build](https://img.shields.io/travis/EvolverGroup/CrossDomainPolicyModule.svg)](https://travis-ci.org/EvolverGroup/CrossDomainPolicyModule)

## Requirements

This module has the following requirements:

- PHP 5.4 or higher

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```bash
$ php composer.phar require evolver/cross-domain-policy-module
```

Then add `Evolver\\CrossDomainPolicyModule` to your application config.

## Usage

Copy and rename the `config/cross-domain-policy.config.php.dist` to your application autoload folder. Then customize the
config for your needs.
Visit the [Cross-domain policy file specification](http://www.adobe.com/devnet-docs/acrobatetk/tools/AppSec/CrossDomain_PolicyFile_Specification.pdf)
for details.

You may now invoke yor application via HTTP. The route `/crossdomain.xml` will point on the resulting cross-domain
policy XML.
