<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Factory\QueryFactory;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\AlbumResponse;
use Kerox\Spotify\Response\AlbumsResponse;
use Kerox\Spotify\Response\PagingResponse;
use Psr\Http\Message\ResponseInterface;

class Albums extends AbstractApi
{
    /**
     * @param string $id
     * @param array  $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @return \Kerox\Spotify\Response\AlbumResponse
     */
    public function getAlbum(string $id, $queryParameters = null): AlbumResponse
    {
        $uri = $this->createUri(sprintf('albums/%s', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new AlbumResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\AlbumsResponse
     */
    public function getAlbums(array $queryParameters = []): AlbumsResponse
    {
        $uri = $this->createUri('albums', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new AlbumsResponse($response);
    }

    /**
     * @param string $id
     * @param array  $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\PagingResponse
     */
    public function getTracks(string $id, array $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri(sprintf('albums/%s/tracks', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }
}
