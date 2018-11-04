<?php

declare(strict_types=1);

namespace Kerox\Spotify;

use Kerox\Spotify\Api\Albums;
use Kerox\Spotify\Api\Artists;
use Kerox\Spotify\Api\Browse;
use Kerox\Spotify\Api\Follow;
use Kerox\Spotify\Api\Library;
use Kerox\Spotify\Api\Me;
use Kerox\Spotify\Api\Personalization;
use Kerox\Spotify\Api\Player;
use Kerox\Spotify\Api\Playlists;
use Kerox\Spotify\Api\Search;
use Kerox\Spotify\Api\Tracks;
use Kerox\Spotify\Api\Users;
use Psr\Http\Client\ClientInterface;

class Spotify
{
    public const API_URL = 'https://api.spotify.com';
    public const API_VERSION = 'v1';

    /**
     * @var string
     */
    protected $oauthToken;

    /**
     * @var \Psr\Http\Client\ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * Spotify constructor.
     *
     * @param string                           $oauthToken
     * @param \Psr\Http\Client\ClientInterface $client
     */
    public function __construct(string $oauthToken, ClientInterface $client)
    {
        $this->oauthToken = $oauthToken;
        $this->client = $client;
        $this->baseUri = sprintf('%s/%s', self::API_URL, self::API_VERSION);
    }

    /**
     * @return \Kerox\Spotify\Api\Albums
     */
    public function albums(): Albums
    {
        return new Albums($this->oauthToken, $this->client, $this->baseUri);
    }

    /**
     * @return \Kerox\Spotify\Api\Artists
     */
    public function artists(): Artists
    {
        return new Artists($this->oauthToken, $this->client, $this->baseUri);
    }

    /**
     * @return \Kerox\Spotify\Api\Browse
     */
    public function browse(): Browse
    {
        return new Browse($this->oauthToken, $this->client, $this->baseUri);
    }

    /**
     * @return \Kerox\Spotify\Api\Follow
     */
    public function follow(): Follow
    {
        return new Follow($this->oauthToken, $this->client, $this->baseUri);
    }

    /**
     * @return \Kerox\Spotify\Api\Library
     */
    public function library(): Library
    {
        return new Library($this->oauthToken, $this->client, $this->baseUri);
    }

    /**
     * @return \Kerox\Spotify\Api\Me
     */
    public function me(): Me
    {
        return new Me($this->oauthToken, $this->client, $this->baseUri);
    }

    /**
     * @return \Kerox\Spotify\Api\Personalization
     */
    public function personalize(): Personalization
    {
        return new Personalization($this->oauthToken, $this->client, $this->baseUri);
    }

    /**
     * @return \Kerox\Spotify\Api\Player
     */
    public function player(): Player
    {
        return new Player($this->oauthToken, $this->client, $this->baseUri);
    }

    /**
     * @return \Kerox\Spotify\Api\Playlists
     */
    public function playlists(): Playlists
    {
        return new Playlists($this->oauthToken, $this->client, $this->baseUri);
    }

    /**
     * @return \Kerox\Spotify\Api\Search
     */
    public function search(): Search
    {
        return new Search($this->oauthToken, $this->client, $this->baseUri);
    }

    /**
     * @return \Kerox\Spotify\Api\Tracks
     */
    public function tracks(): Tracks
    {
        return new Tracks($this->oauthToken, $this->client, $this->baseUri);
    }

    /**
     * @return \Kerox\Spotify\Api\Users
     */
    public function users(): Users
    {
        return new Users($this->oauthToken, $this->client, $this->baseUri);
    }
}
