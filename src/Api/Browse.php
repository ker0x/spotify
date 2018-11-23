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
     * @param string $id
     * @param array  $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\CategoryResponse
     */
    public function category(string $id, array $queryParameters = []): CategoryResponse
    {
        $uri = $this->createUri(sprintf('categories/%s', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new CategoryResponse($response);
    }

    /**
     * @param string $id
     * @param array  $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\PlaylistsResponse
     */
    public function playlists(string $id, array $queryParameters = []): PlaylistsResponse
    {
        $uri = $this->createUri(sprintf('categories/%s/playlists', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PlaylistsResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\CategoriesResponse
     */
    public function categories(array $queryParameters = []): CategoriesResponse
    {
        $uri = $this->createUri('categories', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new CategoriesResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\FeaturedResponse
     */
    public function featured(array $queryParameters = []): FeaturedResponse
    {
        $uri = $this->createUri('browse/featured-playlists', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new FeaturedResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\ReleasesResponse
     */
    public function releases(array $queryParameters = []): ReleasesResponse
    {
        $uri = $this->createUri('browse/new-releases', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new ReleasesResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\RecommendationsResponse
     */
    public function recommendations(array $queryParameters = []): RecommendationsResponse
    {
        $uri = $this->createUri('recommendations', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new RecommendationsResponse($response);
    }
}
