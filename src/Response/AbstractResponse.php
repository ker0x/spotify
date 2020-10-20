<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

abstract class AbstractResponse extends Response
{
    /**
     * AbstractResponse constructor.
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response->getBody(), $response->getStatusCode(), $response->getHeaders());

        $this->parseResponse($this->decodeResponse($response->getBody()));
    }

    private function decodeResponse(StreamInterface $stream): array
    {
        return json_decode($stream->__toString(), true);
    }

    abstract protected function parseResponse(array $content): void;
}
