<?php

declare(strict_types=1);

namespace Kerox\Spotify\Request;

use Psr\Http\Message\UriInterface;

class Request extends \Zend\Diactoros\Request
{
    /**
     * Request constructor.
     *
     * @param string                         $oauthToken
     * @param \Psr\Http\Message\UriInterface $uri
     * @param string                         $method
     * @param string|null                    $body
     */
    public function __construct(string $oauthToken, UriInterface $uri, string $method, string $body = null)
    {
        parent::__construct($uri, $method, $body, [
            'Authorization' => 'Bearer ' . $oauthToken,
            'Content-Type' => 'application/json',
        ]);
    }
}
