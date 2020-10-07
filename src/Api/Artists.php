<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\ArtistResponse;
use Kerox\Spotify\Response\ArtistsResponse;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\TracksResponse;

class Artists extends AbstractApi
{
    public const BASE_URI = 'artists';

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function get(string $id): ArtistResponse
    {
        $uri = $this->createUri(sprintf('artists/%s', $id));

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new ArtistResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function many(iterable $queryParameters = []): ArtistsResponse
    {
        $uri = $this->createUri('artists', $queryParameters);

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new ArtistsResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function albums(string $id, iterable $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri(sprintf('artists/%s', $id), $queryParameters);

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function topTracks(string $id, iterable $queryParameters = []): TracksResponse
    {
        $uri = $this->createUri(sprintf('artists/%s/top-tracks', $id), $queryParameters);

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new TracksResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function relatedArtists(string $id): ArtistsResponse
    {
        $uri = $this->createUri(sprintf('artists/%s/related-artists', $id));

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new ArtistsResponse($response);
    }
}
