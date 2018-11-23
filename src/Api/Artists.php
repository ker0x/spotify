<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Interfaces\TypeInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\ArtistResponse;
use Kerox\Spotify\Response\ArtistsResponse;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\TracksResponse;
use Psr\Http\Message\ResponseInterface;

class Artists extends AbstractApi
{
    /**
     * @param string $id
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\ArtistResponse
     */
    public function get(string $id): ArtistResponse
    {
        $uri = $this->createUri(sprintf('artists/%s', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new ArtistResponse($response);
    }

    /**
     * @param string $id
     * @param array  $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\PagingResponse
     */
    public function albums(string $id, array $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri(sprintf('artists/%s', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @param string $id
     * @param array  $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\TracksResponse
     */
    public function topTracks(string $id, array $queryParameters = []): TracksResponse
    {
        $uri = $this->createUri(sprintf('artists/%s/top-tracks', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new TracksResponse($response);
    }

    /**
     * @param string $id
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\ArtistsResponse
     */
    public function related(string $id): ArtistsResponse
    {
        $uri = $this->createUri(sprintf('artists/%s/related-artists', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new ArtistsResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\ArtistsResponse
     */
    public function several(array $queryParameters = []): ArtistsResponse
    {
        $uri = $this->createUri('artists', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new ArtistsResponse($response);
    }

    /**
     * @param array $ids
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function follow(array $ids): ResponseInterface
    {
        $followClass = new Follow($this->oauthToken, $this->client, $this->baseUri);

        return $followClass->add([
            self::PARAMETER_IDS => $ids,
            self::PARAMETER_TYPE => TypeInterface::TYPE_ARTIST,
        ]);
    }

    /**
     * @param array $ids
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function unfollow(array $ids): ResponseInterface
    {
        $followClass = new Follow($this->oauthToken, $this->client, $this->baseUri);

        return $followClass->delete([
            self::PARAMETER_IDS => $ids,
            self::PARAMETER_TYPE => TypeInterface::TYPE_ARTIST,
        ]);
    }
}
