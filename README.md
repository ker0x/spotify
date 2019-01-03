<div align="center">
    <a href="https://travis-ci.org/ker0x/spotify" title="Build">
        <img src="https://img.shields.io/travis/ker0x/spotify.svg?style=for-the-badge" alt="Build">
    </a>
    <a href="https://scrutinizer-ci.com/g/ker0x/spotify/" title="Coverage">
        <img src="https://img.shields.io/scrutinizer/coverage/g/ker0x/spotify.svg?style=for-the-badge" alt="Coverage">
    </a>
    <a href="https://scrutinizer-ci.com/g/ker0x/spotify/" title="Code Quality">
        <img src="https://img.shields.io/scrutinizer/g/ker0x/spotify.svg?style=for-the-badge" alt="Code Quality">
    </a>
    <a href="https://php.net" title="PHP Version">
        <img src="https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg?style=for-the-badge" alt="PHP Version">
    </a>
    <a href="https://packagist.org/packages/kerox/spotify" title="Downloads">
        <img src="https://img.shields.io/packagist/dt/kerox/spotify.svg?style=for-the-badge" alt="Downloads">
    </a>
    <a href="https://packagist.org/packages/kerox/spotify" title="Latest Stable Version">
        <img src="https://img.shields.io/packagist/v/kerox/spotify.svg?style=for-the-badge" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/kerox/spotify" title="License">
        <img src="https://img.shields.io/packagist/l/kerox/spotify.svg?style=for-the-badge" alt="License">
    </a>
</div>

# Spotify

A PHP Library to easily use [Spotify API](https://developer.spotify.com/documentation/web-api/)

## Warning

This library use [PSR-18 HTTP Client](https://www.php-fig.org/psr/psr-18/) interface, which means that **no** HTTP Client, like [Guzzle](https://github.com/guzzle/guzzle) or [httplug](https://github.com/php-http/httplug), are provided within. You will need to require them separately. 

## Installation

You can install Spotify using Composer:

```
composer require kerox/spotify
```

You will then need to:
* run `composer install` to get these dependencies added to your vendor directory
* add the autoloader to your application with this line: `require('vendor/autoload.php');`

## Advance usage

Please, refer to the [wiki](https://github.com/ker0x/spotify/wiki) to learn how to use this library

## Features

### API

- [x] Albums
- [x] Artists
- [x] Audio
- [x] Browse
- [x] Follow
- [x] Me
- [x] Playlists
- [x] Search
- [x] Tracks
- [x] Users
