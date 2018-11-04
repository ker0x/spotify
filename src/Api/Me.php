<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Interfaces\FollowInterface;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\UserFollowingResponse;
use Kerox\Spotify\Response\UserResponse;
use Psr\Http\Message\ResponseInterface;

class Me extends AbstractApi
{
    /**
     * @throws \Kerox\Spotify\Exception\SpotifyException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get(): ResponseInterface
    {
        $uri = $this->buildUri('me');

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new UserResponse($response);
    }

    public function playlists(): ResponseInterface
    {
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
    public function follow(array $ids): ResponseInterface
    {
        $followClass = new Follow($this->oauthToken, $this->client, $this->baseUri);

        return $followClass->add($ids, Follow::TYPE_USER);
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
    public function unfollow(array $ids): ResponseInterface
    {
        $followClass = new Follow($this->oauthToken, $this->client, $this->baseUri);

        return $followClass->delete($ids, Follow::TYPE_USER);
    }

    /**
     * @param int         $limit
     * @param string|null $after
     *
     * @throws \Kerox\Spotify\Exception\InvalidLimitException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function following(int $limit = 20, string $after = null): ResponseInterface
    {
        $uri = $this->buildUri('me/following', [
            self::PARAMETER_TYPE => FollowInterface::TYPE_ARTIST,
            self::PARAMETER_LIMIT => $limit,
            self::PARAMETER_AFTER => $after,
        ]);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new UserFollowingResponse($response);
    }
}
