<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Zend\Diactoros\Response;

abstract class AbstractResponse extends Response
{
    /**
     * AbstractResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response->getBody(), $response->getStatusCode(), $response->getHeaders());

        $this->parseResponse($this->decodeResponse($response->getBody()));
    }

    /**
     * @param \Psr\Http\Message\StreamInterface $stream
     *
     * @return array
     */
    private function decodeResponse(StreamInterface $stream): array
    {
        return json_decode($stream->__toString(), true);
    }

    /**
     * @param array $content
     */
    abstract protected function parseResponse(array $content): void;
}
