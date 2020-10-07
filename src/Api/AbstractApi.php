<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Spotify;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

abstract class AbstractApi implements RequestFactoryInterface, UriFactoryInterface
{
    private Psr17Factory $factory;

    public function __construct(
        private string $token,
        private ClientInterface $client
    ) {
        $this->factory = new Psr17Factory();
    }

    public function createRequest(string $method, $uri, $body = null): RequestInterface
    {
        $request = $this->factory->createRequest($method, $uri)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Authorization', sprintf('Bearer %s', $this->token))
        ;

        if ($body instanceof \JsonSerializable || \is_array($body)) {
            $content = json_encode($body, JSON_THROW_ON_ERROR);

            $request = $request->withHeader('Content-Type', 'application/json');
            $request = $request->withBody($this->factory->createStream($content));
        }

        return $request;
    }

    public function createUri(string $uri = '', array $queryParameters = []): UriInterface
    {
        $query = [];
        foreach ($queryParameters as $parameter => $value) {
            $query[] = sprintf('%s=%s', $parameter, urlencode((string) $value));
        }

        if (!empty($query)) {
            $uri = sprintf('%s?%s', $uri, implode('&', $query));
        }

        return $this->factory->createUri(
            sprintf(
                '%s/%s/%s',
                Spotify::API_URL,
                Spotify::API_VERSION,
                $uri,
            )
        );
    }

    protected function sendGetRequest(string $uri, array $queryParameters = []): ResponseInterface
    {
        return $this->client->sendRequest(
            $this->createRequest(RequestMethodInterface::METHOD_GET, $this->createUri($uri, $queryParameters))
        );
    }
}
