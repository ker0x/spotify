<?php

declare(strict_types=1);

namespace Kerox\Spotify\Api;

use Fig\Http\Message\RequestMethodInterface;
use Kerox\Spotify\Model\Playlist;
use Kerox\Spotify\Model\Playlist\AddTracks;
use Kerox\Spotify\Model\Playlist\RemoveTracks;
use Kerox\Spotify\Model\Playlist\ReorderTracks;
use Kerox\Spotify\Model\Playlist\ReplaceTracks;
use Kerox\Spotify\Request\Request;
use Kerox\Spotify\Response\ArtistResponse;
use Kerox\Spotify\Response\ImagesResponse;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\PlaylistResponse;
use Psr\Http\Message\ResponseInterface;

class Playlists extends AbstractApi
{
    /**
     * @param string                        $id
     * @param \Kerox\Spotify\Model\Playlist $playlist
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\PlaylistResponse
     */
    public function create(string $id, Playlist $playlist): PlaylistResponse
    {
        $uri = $this->createUri(sprintf('users/%s/playlists', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_POST, $playlist);
        $response = $this->client->sendRequest($request);

        return new PlaylistResponse($response);
    }

    /**
     * @param string                        $id
     * @param \Kerox\Spotify\Model\Playlist $playlist
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(string $id, Playlist $playlist): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_POST, $playlist);

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $id
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\ArtistResponse
     */
    public function get(string $id): ArtistResponse
    {
        $uri = $this->createUri(sprintf('playlists/%s', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT);
        $response = $this->client->sendRequest($request);

        return new ArtistResponse($response);
    }

    /**
     * @param string $id
     * @param bool   $public
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function follow(string $id, bool $public = true): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/followers', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT, json_encode([
            'public' => $public,
        ]));

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $id
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function unfollow(string $id): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/followers', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_DELETE);

        return $this->client->sendRequest($request);
    }

    /**
     * @param array $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\PagingResponse
     */
    public function me(array $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri('me/playlists', $queryParameters);

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
     * @return \Kerox\Spotify\Response\PagingResponse
     */
    public function user(string $id, array $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri(sprintf('users/%s/playlists', $id), $queryParameters);

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
     * @return \Kerox\Spotify\Response\PagingResponse
     */
    public function tracks(string $id, array $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri(sprintf('playlists/%s/tracks', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT);
        $response = $this->client->sendRequest($request);

        return new PagingResponse($response);
    }

    /**
     * @param string                                  $id
     * @param \Kerox\Spotify\Model\Playlist\AddTracks $tracks
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function add(string $id, AddTracks $tracks): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/tracks', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_POST, $tracks);

        return $this->client->sendRequest($request);
    }

    /**
     * @param string                                     $id
     * @param \Kerox\Spotify\Model\Playlist\RemoveTracks $tracks
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function remove(string $id, RemoveTracks $tracks): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/tracks', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_DELETE, $tracks);

        return $this->client->sendRequest($request);
    }

    /**
     * @param string                                      $id
     * @param \Kerox\Spotify\Model\Playlist\ReorderTracks $tracks
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function reorder(string $id, ReorderTracks $tracks): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/tracks', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT, $tracks);

        return $this->client->sendRequest($request);
    }

    /**
     * @param string                                      $id
     * @param \Kerox\Spotify\Model\Playlist\ReplaceTracks $tracks
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function replace(string $id, ReplaceTracks $tracks): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/tracks', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT, $tracks);

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $id
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\ImagesResponse
     */
    public function cover(string $id): ImagesResponse
    {
        $uri = $this->createUri(sprintf('playlists/%s/images', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new ImagesResponse($response);
    }

    /**
     * @param string $id
     * @param string $image
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function upload(string $id, string $image): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/images', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT, $image, [
            'Content-Type' => 'image/jpeg',
        ]);

        return $this->client->sendRequest($request);
    }
}
