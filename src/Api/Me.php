<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Factory\QueryFactory;
use Kerox\Spotify\Interfaces\TypeInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\UserFollowingResponse;
use Kerox\Spotify\Response\UserResponse;
use Psr\Http\Message\ResponseInterface;

class Me extends AbstractApi implements TypeInterface
{
    public const BASE_URI = 'me';

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function profile(): UserResponse
    {
        $request = $this->createRequest(RequestMethodInterface::METHOD_GET, 'me');
        $response = $this->client->sendRequest($request);

        return new UserResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function playlists(iterable $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri('me/playlists', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function top(string $type = self::TYPE_ARTISTS, iterable $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri(sprintf('me/top/%s', $type), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function savedAlbums(iterable $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri('me/albums', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function addAlbums(iterable $queryParameters = []): ResponseInterface
    {
        $uri = $this->createUri('me/albums', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT);

        return $this->client->sendRequest($request);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function deleteAlbums(iterable $queryParameters = []): ResponseInterface
    {
        $uri = $this->createUri('me/albums', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_DELETE);

        return $this->client->sendRequest($request);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function savedTracks(iterable $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri('me/tracks', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function addTracks(iterable $queryParameters = []): ResponseInterface
    {
        $uri = $this->createUri('me/tracks', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT);

        return $this->client->sendRequest($request);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function deleteTracks(iterable $queryParameters = []): ResponseInterface
    {
        $uri = $this->createUri('me/tracks', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_DELETE);

        return $this->client->sendRequest($request);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function followArtists(array $ids): ResponseInterface
    {
        $followClass = new Follow($this->oauthToken, $this->client, $this->baseUri);
        $query = (new QueryFactory())->setIds($ids)->setType(TypeInterface::TYPE_ARTIST);

        return $followClass->add($query);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function unfollowArtists(array $ids): ResponseInterface
    {
        $followClass = new Follow($this->oauthToken, $this->client, $this->baseUri);
        $query = (new QueryFactory())->setIds($ids)->setType(TypeInterface::TYPE_ARTIST);

        return $followClass->delete($query);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function followUsers(array $ids): ResponseInterface
    {
        $followClass = new Follow($this->oauthToken, $this->client, $this->baseUri);
        $query = (new QueryFactory())->setIds($ids)->setType(TypeInterface::TYPE_USER);

        return $followClass->add($query);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function unfollowUsers(array $ids): ResponseInterface
    {
        $followClass = new Follow($this->oauthToken, $this->client, $this->baseUri);
        $query = (new QueryFactory())->setIds($ids)->setType(TypeInterface::TYPE_USER);

        return $followClass->delete($query);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getFollowing(iterable $queryParameters = []): UserFollowingResponse
    {
        $uri = $this->createUri('me/following', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new UserFollowingResponse($response);
    }
}
