<?php

declare(strict_types=1);

namespace Kerox\Spotify\Request;

use JsonSerializable;
use Psr\Http\Message\UriInterface;

class Request extends \Laminas\Diactoros\Request
{
    /**
     * Request constructor.
     *
     * @param mixed $body
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
            $body = json_encode($body);

            $headers += ['Content-Type' => 'application/json'];
        }

        parent::__construct($uri, $method, $body, $headers);
    }
}
