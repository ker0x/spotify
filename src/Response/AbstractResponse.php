<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

abstract class AbstractResponse extends Response
{
    /**
     * AbstractResponse constructor.
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response->getBody(), $response->getStatusCode(), $response->getHeaders());

        $this->parseResponse(json_decode((string) $response->getBody(), true));
    }

    abstract protected function parseResponse(array $content): void;
}
