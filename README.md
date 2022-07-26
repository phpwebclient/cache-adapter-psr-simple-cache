[![Latest Stable Version](https://img.shields.io/packagist/v/webclient/cache-adapter-psr-simple-cache.svg?style=flat-square)](https://packagist.org/packages/webclient/cache-adapter-psr-simple-cache)
[![Total Downloads](https://img.shields.io/packagist/dt/webclient/cache-adapter-psr-simple-cache.svg?style=flat-square)](https://packagist.org/packages/webclient/cache-adapter-psr-simple-cache/stats)
[![License](https://img.shields.io/packagist/l/webclient/cache-adapter-psr-simple-cache.svg?style=flat-square)](https://github.com/phpwebclient/cache-adapter-psr-simple-cache/blob/master/LICENSE)
[![PHP](https://img.shields.io/packagist/php-v/webclient/cache-adapter-psr-simple-cache.svg?style=flat-square)](https://php.net)

# webclient/cache-adapter-psr-simple-cache

[psr/simple-cache](https://packagist.org/packages/psr/simple-cache) adapter for [webclient/cache-contract](https://packagist.org/packages/webclient/cache-contract)

# Install

Install this package and your favorite [psr-16 implementation](https://packagist.org/providers/psr/simple-cache-implementation).

Install this package
```bash
composer require webclient/cache-adapter-psr-simple-cache:^2.0
```

# Usage
```php
<?php

/** @var \Psr\SimpleCache\CacheInterface $psrSimpleCache */
$psrCacheAdapter = new \Webclient\Cache\Adapter\PsrSimpleCache\PsrSimpleCacheAdapter($psrSimpleCache);

```
