<?php

declare(strict_types=1);

namespace Kerox\Spotify;

use Kerox\Spotify\Api\Albums;
use Kerox\Spotify\Api\Artists;
use Kerox\Spotify\Api\Audio;
use Kerox\Spotify\Api\Browse;
use Kerox\Spotify\Api\Follow;
use Kerox\Spotify\Api\Me;
use Kerox\Spotify\Api\Playlists;
use Kerox\Spotify\Api\Search;
use Kerox\Spotify\Api\Tracks;
use Kerox\Spotify\Api\Users;
use Kerox\Spotify\Response\SearchResponse;
use Psr\Http\Client\ClientInterface;

final class Spotify
{
    public const API_URL = 'https://api.spotify.com';
    public const API_VERSION = 'v1';

    public function __construct(
        private string $oauthToken,
        private ClientInterface $client
    ) {
    }

    public function albums(): Albums
    {
        return new Albums($this->oauthToken, $this->client);
    }

    public function artists(): Artists
    {
        return new Artists($this->oauthToken, $this->client);
    }

    public function audio(): Audio
    {
        return new Audio($this->oauthToken, $this->client);
    }

    public function browse(): Browse
    {
        return new Browse($this->oauthToken, $this->client);
    }

    public function follow(): Follow
    {
        return new Follow($this->oauthToken, $this->client);
    }

    public function me(): Me
    {
        return new Me($this->oauthToken, $this->client);
    }

    public function playlists(): Playlists
    {
        return new Playlists($this->oauthToken, $this->client);
    }

    public function search(array $queryParameters = []): SearchResponse
    {
        $search = new Search($this->oauthToken, $this->client);

        return $search($queryParameters);
    }

    public function tracks(): Tracks
    {
        return new Tracks($this->oauthToken, $this->client);
    }

    public function users(): Users
    {
        return new Users($this->oauthToken, $this->client);
    }
}
