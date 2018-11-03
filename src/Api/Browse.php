<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\CategoriesResponse;
use Kerox\Spotify\Response\CategoryResponse;
use Kerox\Spotify\Response\FeaturedResponse;
use Kerox\Spotify\Response\ReleasesResponse;
use Kerox\Spotify\Response\PlaylistsResponse;
use Kerox\Spotify\Response\RecommendationsResponse;
use Psr\Http\Message\ResponseInterface;

class Browse extends AbstractApi
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
    public function category(string $id, array $queryParameters = []): ResponseInterface
    {
        $this->isValidQueryParameters($queryParameters, [
            self::PARAMETER_COUNTRY,
            self::PARAMETER_LOCALE
        ]);

        $uri = $this->buildUri(sprintf('categories/%s', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new CategoryResponse($response);
    }

    /**
     * @param string $id
     * @param array  $queryParameters
     *
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Kerox\Spotify\Exception\InvalidQueryParameterException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function playlists(string $id, array $queryParameters = []): ResponseInterface
    {
        $this->isValidQueryParameters($queryParameters, [
            self::PARAMETER_COUNTRY,
            self::PARAMETER_LIMIT,
            self::PARAMETER_OFFSET,
        ]);

        $uri = $this->buildUri(sprintf('categories/%s/playlists', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PlaylistsResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Kerox\Spotify\Exception\InvalidQueryParameterException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function categories(array $queryParameters = []): ResponseInterface
    {
        $this->isValidQueryParameters($queryParameters, [
            self::PARAMETER_COUNTRY,
            self::PARAMETER_LOCALE,
            self::PARAMETER_LIMIT,
            self::PARAMETER_OFFSET,
        ]);

        $uri = $this->buildUri('categories', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new CategoriesResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Kerox\Spotify\Exception\InvalidQueryParameterException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function featured(array $queryParameters = []): ResponseInterface
    {
        $this->isValidQueryParameters($queryParameters, [
            self::PARAMETER_COUNTRY,
            self::PARAMETER_LOCALE,
            self::PARAMETER_TIMESTAMP,
            self::PARAMETER_LIMIT,
            self::PARAMETER_OFFSET,
        ]);

        $uri = $this->buildUri('browse/featured-playlists', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new FeaturedResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Kerox\Spotify\Exception\InvalidQueryParameterException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function releases(array $queryParameters = []): ResponseInterface
    {
        $this->isValidQueryParameters($queryParameters, [
            self::PARAMETER_COUNTRY,
            self::PARAMETER_LIMIT,
            self::PARAMETER_OFFSET,
        ]);

        $uri = $this->buildUri('browse/new-releases', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new ReleasesResponse($response);
    }

    public function recommendations(array $queryParameters = []): ResponseInterface
    {
        $this->isValidQueryParameters($queryParameters, [
            self::PARAMETER_LIMIT,
            self::PARAMETER_MARKET,
            self::PARAMETER_SEED_ARTISTS,
            self::PARAMETER_SEED_GENRES,
            self::PARAMETER_SEED_TRACKS,
        ]);

        $uri = $this->buildUri('recommendations', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new RecommendationsResponse($response);
    }
}
