<?php

declare(strict_types=1);

namespace Kerox\Spotify\Request;

use JsonSerializable;
use Psr\Http\Message\UriInterface;

class Request extends \Zend\Diactoros\Request
{
    /**
     * Request constructor.
     *
     * @param string                         $oauthToken
     * @param \Psr\Http\Message\UriInterface $uri
     * @param string                         $method
     * @param mixed                          $body
     * @param array                          $headers
     */
    public function __construct(
        string $oauthToken,
        UriInterface $uri,
        string $method,
        $body = 'php://temp',
        array $headers = []
    ) {
        $headers += ['Authorization' => sprintf('Bearer %s', $oauthToken)];
        if ($body instanceof JsonSerializable || \is_array($body)) {
            $body = json_encode($body, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE);

            $headers += ['Content-Type' => 'application/json'];
        }

        parent::__construct($uri, $method, $body, $headers);
    }
}
