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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function updatePlaylist(string $id, Playlist $playlist): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT, $playlist);

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $id
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\PlaylistResponse
     */
    public function getPlaylist(string $id): PlaylistResponse
    {
        $uri = $this->createUri(sprintf('playlists/%s', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
        $response = $this->client->sendRequest($request);

        return new PlaylistResponse($response);
    }

    /**
     * @param string $id
     * @param array  $queryParameters
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Spotify\Response\PagingResponse
     */
    public function getTracks(string $id, array $queryParameters = []): PagingResponse
    {
        $uri = $this->createUri(sprintf('playlists/%s/tracks', $id), $queryParameters);

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_GET);
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
    public function addTracks(string $id, AddTracks $tracks): ResponseInterface
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
    public function removeTracks(string $id, RemoveTracks $tracks): ResponseInterface
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
    public function reorderTracks(string $id, ReorderTracks $tracks): ResponseInterface
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
    public function replaceTracks(string $id, ReplaceTracks $tracks): ResponseInterface
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
    public function getCover(string $id): ImagesResponse
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
    public function uploadCover(string $id, string $image): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/images', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT, $image, [
            'Content-Type' => 'image/jpeg',
        ]);

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $id
     * @param bool   $public
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function followPlaylist(string $id, bool $public = true): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/followers', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_PUT, [
            'public' => $public,
        ]);

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $id
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function unfollowPlaylist(string $id): ResponseInterface
    {
        $uri = $this->createUri(sprintf('playlists/%s/followers', $id));

        $request = new Request($this->oauthToken, $uri, RequestMethodInterface::METHOD_DELETE);

        return $this->client->sendRequest($request);
    }
}
