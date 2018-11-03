<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
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
     * @throws \Kerox\Spotify\Exception\SpotifyException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get(string $id): ResponseInterface
    {
        $uri = $this->buildUri(sprintf('artists/%s', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new ArtistResponse($response);
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
    public function albums(string $id, array $queryParameters = []): ResponseInterface
    {
        $this->isValidQueryParameters($queryParameters, [
            self::PARAMETER_INCLUDE_GROUPS,
            self::PARAMETER_MARKET,
            self::PARAMETER_COUNTRY,
            self::PARAMETER_LIMIT,
            self::PARAMETER_OFFSET,
        ]);

        $uri = $this->buildUri(sprintf('artists/%s', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @param string $id
     * @param array  $queryParameters
     *
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Kerox\Spotify\Exception\InvalidQueryParameterException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function topTracks(string $id, array $queryParameters = []): ResponseInterface
    {
        $this->isValidQueryParameters($queryParameters, [
            self::PARAMETER_MARKET,
        ]);

        $uri = $this->buildUri(sprintf('artists/%s/top-tracks', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new TracksResponse($response);
    }

    /**
     * @param string $id
     *
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function related(string $id): ResponseInterface
    {
        $uri = $this->buildUri(sprintf('artists/%s/related-artists', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new ArtistsResponse($response);
    }

    /**
     * @param array $ids
     *
     * @throws \Kerox\Spotify\Exception\InvalidArrayException
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function several(array $ids): ResponseInterface
    {
        $this->isValidArray($ids, 50);

        $uri = $this->buildUri('artists', [
            self::PARAMETER_IDS => $ids,
        ]);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new ArtistsResponse($response);
    }

    public function following(array $ids): ResponseInterface
    {

    }
}
