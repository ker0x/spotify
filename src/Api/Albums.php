<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\AlbumResponse;
use Kerox\Spotify\Response\AlbumsResponse;
use Kerox\Spotify\Response\PagingResponse;
use Psr\Http\Message\ResponseInterface;

class Albums extends AbstractApi
{
    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function get(string $id, array $queryParameters = []): AlbumResponse
    {
        $uri = $this->createUri(sprintf('albums/%s', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new AlbumResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function tracks(string $id, array $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri(sprintf('albums/%s/tracks', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function several(array $queryParameters = []): AlbumsResponse
    {
        $uri = $this->createUri('albums', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new AlbumsResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function saved(array $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri('me/albums', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function add(array $queryParameters = []): ResponseInterface
    {
        $uri = $this->createUri('me/albums', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT);

        return $this->client->sendRequest($request);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function remove(array $queryParameters = []): ResponseInterface
    {
        $uri = $this->createUri('me/albums', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_DELETE);

        return $this->client->sendRequest($request);
    }
}
