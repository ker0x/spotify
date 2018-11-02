<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\AlbumResponse;
use Kerox\Spotify\Response\AlbumsResponse;
use Kerox\Spotify\Response\AlbumTracksResponse;
use Psr\Http\Message\ResponseInterface;

class Albums extends AbstractApi
{
    /**
     * @param string $id
     * @param array  $queryParameters
     *
     * @throws \Kerox\Spotify\Exception\SpotifyException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get(string $id, array $queryParameters = []): ResponseInterface
    {
        $this->isValidQueryParameters($queryParameters, [self::PARAMETER_MARKET]);

        $uri = $this->buildUri(sprintf('albums/%s', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new AlbumResponse($response);
    }

    /**
     * @param string $id
     * @param array  $queryParameters
     *
     * @throws \Kerox\Spotify\Exception\SpotifyException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function tracks(string $id, array $queryParameters = []): ResponseInterface
    {
        $this->isValidQueryParameters($queryParameters, [
            self::PARAMETER_MARKET,
            self::PARAMETER_LIMIT,
            self::PARAMETER_OFFSET,
        ]);

        $uri = $this->buildUri(sprintf('albums/%s/tracks', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new AlbumTracksResponse($response);
    }

    /**
     * @param array $ids
     * @param array $queryParameters
     *
     * @throws \Kerox\Spotify\Exception\SpotifyException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function several(array $ids, array $queryParameters = []): ResponseInterface
    {
        $this->isValidArray($ids, 20);
        $this->isValidQueryParameters($queryParameters, [self::PARAMETER_MARKET]);

        $queryParameters += [self::PARAMETER_IDS => $ids];

        $uri = $this->buildUri('albums', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new AlbumsResponse($response);
    }
}
