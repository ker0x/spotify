<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\ArtistResponse;
use Kerox\Spotify\Response\PagingResponse;
use Psr\Http\Message\ResponseInterface;

class Playlists extends AbstractApi
{
    public function create(): ResponseInterface
    {
    }

    public function update(): ResponseInterface
    {
    }

    public function get(string $id): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT);
        $response = $this->client->sendRequest($request);

        return new ArtistResponse($response);
    }

    public function tracks(string $id, array $queryParameters = []): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/tracks', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    public function remove(): ResponseInterface
    {
    }

    public function reorder(): ResponseInterface
    {
    }

    public function replace(): ResponseInterface
    {
    }

    /**
     * @param string $id
     * @param bool   $public
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function follow(string $id, bool $public = true): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/followers', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT, json_encode([
            'public' => $public,
        ]));

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $id
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function unfollow(string $id): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/followers', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_DELETE);

        return $this->client->sendRequest($request);
    }

    public function cover(): ResponseInterface
    {
    }

    public function images(): ResponseInterface
    {
    }
}
