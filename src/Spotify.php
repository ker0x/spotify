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

    /**
     * @var string
     */
    private $oauthToken;

    /**
     * @var \Psr\Http\Client\ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * Spotify constructor.
     */
    public function __construct(string $oauthToken, ClientInterface $client)
    {
        $this->oauthToken = $oauthToken;
        $this->client = $client;
        $this->baseUri = sprintf('%s/%s', self::API_URL, self::API_VERSION);
    }

    public function albums(): Albums
    {
        return new Albums($this->oauthToken, $this->client, $this->baseUri);
    }

    public function artists(): Artists
    {
        return new Artists($this->oauthToken, $this->client, $this->baseUri);
    }

    public function audio(): Audio
    {
        return new Audio($this->oauthToken, $this->client, $this->baseUri);
    }

    public function browse(): Browse
    {
        return new Browse($this->oauthToken, $this->client, $this->baseUri);
    }

    public function follow(): Follow
    {
        return new Follow($this->oauthToken, $this->client, $this->baseUri);
    }

    public function me(): Me
    {
        return new Me($this->oauthToken, $this->client, $this->baseUri);
    }

    public function playlists(): Playlists
    {
        return new Playlists($this->oauthToken, $this->client, $this->baseUri);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function search(array $queryParameters = []): SearchResponse
    {
        $search = new Search($this->oauthToken, $this->client, $this->baseUri);

        return $search($queryParameters);
    }

    public function tracks(): Tracks
    {
        return new Tracks($this->oauthToken, $this->client, $this->baseUri);
    }

    public function users(): Users
    {
        return new Users($this->oauthToken, $this->client, $this->baseUri);
    }
}
