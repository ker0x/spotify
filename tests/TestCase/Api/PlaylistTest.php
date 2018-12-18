<?php

namespace Kerox\Spotify\Test\TestCase\Api;

use DateTimeImmutable;
use Kerox\Spotify\Interfaces\QueryParametersInterface;
use Kerox\Spotify\Model\External;
use Kerox\Spotify\Model\Followers;
use Kerox\Spotify\Model\Image;
use Kerox\Spotify\Model\Paging;
use Kerox\Spotify\Model\Playlist;
use Kerox\Spotify\Model\SavedTrack;
use Kerox\Spotify\Model\User;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\PlaylistResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Zend\Diactoros\Response;

class PlaylistTest extends TestCase
{
    protected $oauthToken;

    protected function setUp()
    {
        $this->oauthToken = 'BQCpTK7nCpmijQURqGm-hBvOgS4T--ql1zfbiBVYwbzFb4z06fP8pFvLoiDSjSNawQEfRahU3pCJOQJIyhvi1JcmQtLJ_Oh-p3vKWhEfesG-UcIF_tPBjGRSn1Xu1w0QIbrvN9RnSm2-EI_NeNEOBxBHTlviYhq128bjG4obEeemHMIyAE2dJPIwumC-XPqfjXwkUGOVyfu5BJqERSVcT65m-g0xu9T52Q1RpJfvm5J0nGZw5Z647IEucZjqavtWycL2YnXLd02tSt9E0YY';
    }

    protected function tearDown()
    {
        unset($this->oauthToken);
    }

    public function testGetAPlaylist(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Playlist/get.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(PlaylistResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->get('3cEYpjA9oz9GiPac4AsH4n', [
            QueryParametersInterface::PARAMETER_MARKET => 'FR'
        ]);

        $playlist = $response->getPlaylist();

        $this->assertFalse($playlist->isCollaborative());
        $this->assertSame('A playlist for testing pourposes', $playlist->getDescription());
        $this->assertContainsOnlyInstancesOf(External::class, $playlist->getExternalUrls());
        $this->assertInstanceOf(Followers::class, $playlist->getFollowers());
        $this->assertSame('https://api.spotify.com/v1/playlists/3cEYpjA9oz9GiPac4AsH4n', $playlist->getHref());
        $this->assertSame('3cEYpjA9oz9GiPac4AsH4n', $playlist->getId());
        $this->assertContainsOnlyInstancesOf(Image::class, $playlist->getImages());
        $this->assertSame('Spotify Web API Testing playlist', $playlist->getName());
        $this->assertInstanceOf(User::class, $playlist->getOwner());
        $this->assertNull($playlist->getPrimaryColor());
        $this->assertTrue($playlist->isPublic());
        $this->assertSame('MTcsZDhlNTBiODE0ZTExZDExYjM4NGFlZmFlOTQ1NGE1NTk3ZjNmM2RmOQ==', $playlist->getSnapshotId());
        $this->assertInstanceOf(Paging::class, $playlist->getTracks());
        $this->assertInstanceOf(DateTimeImmutable::class, $playlist->getTracks()->getItem(0)->getAddedAt());
        $this->assertInstanceOf(User::class, $playlist->getTracks()->getItem(0)->getAddedBy());
        $this->assertFalse($playlist->getTracks()->getItem(0)->isLocal());
        $this->assertNull($playlist->getTracks()->getItem(0)->getPrimaryColor());
        $this->assertContainsOnlyInstancesOf(External::class, $playlist->getTracks()->getItem(0)->getVideoThumbnail());
        $this->assertSame('playlist', $playlist->getType());
        $this->assertSame('spotify:user:jmperezperez:playlist:3cEYpjA9oz9GiPac4AsH4n', $playlist->getUri());
    }

    public function testGetCurrentUserPlaylist(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Playlist/me.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(PagingResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->me([
            QueryParametersInterface::PARAMETER_LIMIT => 10,
            QueryParametersInterface::PARAMETER_OFFSET => 5,
        ]);

        $paging = $response->getPaging();

        $this->assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=5&limit=10', $paging->getHref());
        $this->assertContainsOnlyInstancesOf(Playlist::class, $paging->getItems());
        $this->assertSame(10, $paging->getLimit());
        $this->assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=15&limit=10', $paging->getNext());
        $this->assertSame(5, $paging->getOffset());
        $this->assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=0&limit=10', $paging->getPrevious());
        $this->assertSame(43, $paging->getTotal());
    }

    public function testGetUserPlaylist(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Playlist/user.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(PagingResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->user('1199545168', [
            QueryParametersInterface::PARAMETER_LIMIT => 10,
            QueryParametersInterface::PARAMETER_OFFSET => 5,
        ]);

        $paging = $response->getPaging();

        $this->assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=5&limit=10', $paging->getHref());
        $this->assertContainsOnlyInstancesOf(Playlist::class, $paging->getItems());
        $this->assertSame(10, $paging->getLimit());
        $this->assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=15&limit=10', $paging->getNext());
        $this->assertSame(5, $paging->getOffset());
        $this->assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=0&limit=10', $paging->getPrevious());
        $this->assertSame(43, $paging->getTotal());
    }

    public function testGetPlaylistTracks(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Playlist/tracks.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(PagingResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->tracks('37i9dQZF1DWVFJtzvDHN4L', [
            QueryParametersInterface::PARAMETER_MARKET => 'FR',
            QueryParametersInterface::PARAMETER_LIMIT => 1,
            QueryParametersInterface::PARAMETER_OFFSET => 0,
        ]);

        $paging = $response->getPaging();

        $this->assertSame('https://api.spotify.com/v1/playlists/37i9dQZF1DWVFJtzvDHN4L/tracks?offset=0&limit=1&market=FR', $paging->getHref());
        $this->assertContainsOnlyInstancesOf(SavedTrack::class, $paging->getItems());
        $this->assertSame(1, $paging->getLimit());
        $this->assertSame('https://api.spotify.com/v1/playlists/37i9dQZF1DWVFJtzvDHN4L/tracks?offset=1&limit=1&market=FR', $paging->getNext());
        $this->assertSame(0, $paging->getOffset());
        $this->assertNull($paging->getPrevious());
        $this->assertSame(50, $paging->getTotal());
    }

    public function testFollowPlaylist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->follow('37i9dQZF1DWVFJtzvDHN4L');

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testUnfollowPlaylist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->unfollow('37i9dQZF1DWVFJtzvDHN4L');

        $this->assertSame(200, $response->getStatusCode());
    }
}
