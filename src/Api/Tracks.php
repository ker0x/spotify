<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\TrackResponse;
use Kerox\Spotify\Response\TracksResponse;
use Psr\Http\Message\ResponseInterface;

class Tracks extends AbstractApi
{
    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function get(string $id, array $queryParameters = []): TrackResponse
    {
        $uri = $this->createUri(sprintf('tracks/%s', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new TrackResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function several(array $queryParameters = []): TracksResponse
    {
        $uri = $this->createUri('tracks', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new TracksResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function saved(array $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri('me/tracks', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function add(array $queryParameters = []): ResponseInterface
    {
        $uri = $this->createUri('me/tracks', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT);

        return $this->client->sendRequest($request);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function remove(array $queryParameters = []): ResponseInterface
    {
        $uri = $this->createUri('me/tracks', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_DELETE);

        return $this->client->sendRequest($request);
    }
}
