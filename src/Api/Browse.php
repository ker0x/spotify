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
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function category(string $id, array $queryParameters = []): CategoryResponse
    {
        $uri = $this->createUri(sprintf('categories/%s', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new CategoryResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function playlists(string $id, array $queryParameters = []): PlaylistsResponse
    {
        $uri = $this->createUri(sprintf('categories/%s/playlists', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PlaylistsResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function categories(array $queryParameters = []): CategoriesResponse
    {
        $uri = $this->createUri('categories', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new CategoriesResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function featured(array $queryParameters = []): FeaturedResponse
    {
        $uri = $this->createUri('browse/featured-playlists', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new FeaturedResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function releases(array $queryParameters = []): ReleasesResponse
    {
        $uri = $this->createUri('browse/new-releases', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new ReleasesResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function recommendations(array $queryParameters = []): RecommendationsResponse
    {
        $uri = $this->createUri('recommendations', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new RecommendationsResponse($response);
    }
}
