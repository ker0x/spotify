<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Model\Playlist;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\PlaylistResponse;
use Kerox\Spotify\Response\UserResponse;

class Users extends AbstractApi
{
    public const BASE_URI = 'users';

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function profile(string $id): UserResponse
    {
        $uri = $this->createUri(sprintf('users/%s', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new UserResponse($response);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function createPlaylist(string $id, Playlist $playlist): PlaylistResponse
    {
        $uri = $this->createUri(sprintf('users/%s/playlists', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_POST, $playlist);
        $response = $this->client->sendRequest($request);

        return new PlaylistResponse($response);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getPlaylists(string $id, iterable $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri(sprintf('users/%s/playlists', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }
}
