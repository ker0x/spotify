<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\CategoriesResponse;
use Kerox\Spotify\Response\CategoryResponse;
use Kerox\Spotify\Response\FeaturedResponse;
use Kerox\Spotify\Response\PlaylistsResponse;
use Kerox\Spotify\Response\RecommendationsResponse;
use Kerox\Spotify\Response\ReleasesResponse;

class Browse extends AbstractApi
{
    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function category(string $id, iterable $queryParameters = []): CategoryResponse
    {
        $uri = $this->createUri(sprintf('categories/%s', $id), $queryParameters);

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new CategoryResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function categories(iterable $queryParameters = []): CategoriesResponse
    {
        $uri = $this->createUri('categories', $queryParameters);

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new CategoriesResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function categoryPlaylists(string $id, iterable $queryParameters = []): PlaylistsResponse
    {
        $uri = $this->createUri(sprintf('categories/%s/playlists', $id), $queryParameters);

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new PlaylistsResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function featuredPlaylists(iterable $queryParameters = []): FeaturedResponse
    {
        $uri = $this->createUri('browse/featured-playlists', $queryParameters);

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new FeaturedResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function newReleases(iterable $queryParameters = []): ReleasesResponse
    {
        $uri = $this->createUri('browse/new-releases', $queryParameters);

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new ReleasesResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function recommendations(iterable $queryParameters = []): RecommendationsResponse
    {
        $uri = $this->createUri('recommendations', $queryParameters);

        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, $uri);
        $response = $this->client->sendRequest($request);

        return new RecommendationsResponse($response);
    }
}
