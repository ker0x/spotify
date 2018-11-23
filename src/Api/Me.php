<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Interfaces\TypeInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\UserFollowingResponse;
use Kerox\Spotify\Response\UserResponse;
use Psr\Http\Message\ResponseInterface;

class Me extends AbstractApi implements TypeInterface
{
    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\UserResponse
     */
    public function get(): UserResponse
    {
        $uri = $this->createUri('me');

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new UserResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\PagingResponse
     */
    public function playlists(array $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri('me/playlists', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @param string $type
     * @param array  $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\PagingResponse
     */
    public function top(string $type = self::TYPE_ARTISTS, array $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri(sprintf('me/top/%s', $type), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
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
            self::PARAMETER_TYPE => Follow::TYPE_USER,
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
            self::PARAMETER_TYPE => Follow::TYPE_USER,
        ]);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\UserFollowingResponse
     */
    public function following(array $queryParameters = []): UserFollowingResponse
    {
        $uri = $this->createUri('me/following', $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new UserFollowingResponse($response);
    }
}
