<?php

namespace Kerox\Spotify\Test\TestCase\Api;

use DateTime;
use Kerox\Spotify\Interfaces\QueryParametersInterface;
use Kerox\Spotify\Model\External;
use Kerox\Spotify\Model\Followers;
use Kerox\Spotify\Model\Image;
use Kerox\Spotify\Model\Paging;
use Kerox\Spotify\Model\Playlist;
use Kerox\Spotify\Model\Playlist\AddTracks;
use Kerox\Spotify\Model\Playlist\RemoveTracks;
use Kerox\Spotify\Model\Playlist\ReplaceTracks;
use Kerox\Spotify\Model\SavedTrack;
use Kerox\Spotify\Model\TrackLink;
use Kerox\Spotify\Model\User;
use Kerox\Spotify\Response\ImagesResponse;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\PlaylistResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

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
            QueryParametersInterface::PARAMETER_MARKET => 'FR',
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
        $this->assertInstanceOf(SavedTrack::class, $playlist->getTracks()->getItem(0));
        $this->assertSame('playlist', $playlist->getType());
        $this->assertSame('spotify:user:jmperezperez:playlist:3cEYpjA9oz9GiPac4AsH4n', $playlist->getUri());

        /* @var \Kerox\Spotify\Model\SavedTrack $savedTrack */
        $savedTrack = $playlist->getTracks()->getItem(0);

        $this->assertInstanceOf(DateTime::class, $savedTrack->getAddedAt());
        $this->assertInstanceOf(User::class, $savedTrack->getAddedBy());
        $this->assertFalse($savedTrack->isLocal());
        $this->assertNull($savedTrack->getPrimaryColor());
        $this->assertInstanceOf(TrackLink::class, $savedTrack->getTrack()->getLinkedFrom());
        $this->assertContainsOnlyInstancesOf(External::class, $savedTrack->getVideoThumbnail());

        /* @var \Kerox\Spotify\Model\TrackLink $trackLink */
        $trackLink = $savedTrack->getTrack()->getLinkedFrom();
        $this->assertContainsOnlyInstancesOf(External::class, $trackLink->getExternalUrls());
        $this->assertSame('https://api.spotify.com/v1/tracks/5o3jMYOSbaVz3tkgwhELSV', $trackLink->getHref());
        $this->assertSame('5o3jMYOSbaVz3tkgwhELSV', $trackLink->getId());
        $this->assertSame('track', $trackLink->getType());
        $this->assertSame('spotify:track:5o3jMYOSbaVz3tkgwhELSV', $trackLink->getUri());
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

        $this->assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=5&limit=10',
            $paging->getHref());
        $this->assertContainsOnlyInstancesOf(Playlist::class, $paging->getItems());
        $this->assertSame(10, $paging->getLimit());
        $this->assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=15&limit=10',
            $paging->getNext());
        $this->assertSame(5, $paging->getOffset());
        $this->assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=0&limit=10',
            $paging->getPrevious());
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

        $this->assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=5&limit=10',
            $paging->getHref());
        $this->assertContainsOnlyInstancesOf(Playlist::class, $paging->getItems());
        $this->assertSame(10, $paging->getLimit());
        $this->assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=15&limit=10',
            $paging->getNext());
        $this->assertSame(5, $paging->getOffset());
        $this->assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=0&limit=10',
            $paging->getPrevious());
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

        $this->assertSame('https://api.spotify.com/v1/playlists/37i9dQZF1DWVFJtzvDHN4L/tracks?offset=0&limit=1&market=FR',
            $paging->getHref());
        $this->assertContainsOnlyInstancesOf(SavedTrack::class, $paging->getItems());
        $this->assertSame(1, $paging->getLimit());
        $this->assertSame('https://api.spotify.com/v1/playlists/37i9dQZF1DWVFJtzvDHN4L/tracks?offset=1&limit=1&market=FR',
            $paging->getNext());
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

    public function testCreateAPlaylist(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Playlist/create.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(PlaylistResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(201);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->create('1199545168', Playlist::create('A New Playlist', false, false, 'A new awesome playlist'));

        $this->assertSame(201, $response->getStatusCode());
        $this->assertInstanceOf(Playlist::class, $response->getPlaylist());
    }

    public function testUpdateAPlaylist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->update('7d2D2S200NyUE5KYs80PwO', Playlist::create('A New Update Playlist', false, false, 'A new awesome update playlist'));

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testAddATrackToAPlaylist(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Playlist/add.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(201);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->add('7d2D2S200NyUE5KYs80PwO', AddTracks::create([
            'spotify:track:7ouMYWpwJ422jRcDASZB7P',
            'spotify:album:0eFHYz8NmK75zSplL5qlfM',
        ], 2));

        $decodedBody = json_decode($response->getBody(), true);

        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame('JbtmHBDBAYu3/bt8BOXKjzKx3i0b6LCa/wVjyl6qQ2Yf6nFXkbmzuEa+ZI/U1yF+', $decodedBody['snapshot_id']);
    }

    public function testRemoveTrackFromAPlaylist(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Playlist/remove.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->remove('7d2D2S200NyUE5KYs80PwO', RemoveTracks::create([
            'spotify:track:7ouMYWpwJ422jRcDASZB7P',
            'spotify:album:0eFHYz8NmK75zSplL5qlfM',
        ], 'jzKx3i0b6LCaJbtmHBDBAYu3bt8BOXKwVjyl6qQ2Yf6nFXkbmzuEa+ZIU1yF+'));

        $decodedBody = json_decode($response->getBody(), true);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('jzKx3i0b6LCaJbtmHBDBAYu3/bt8BOXK/wVjyl6qQ2Yf6nFXkbmzuEa+ZI/U1yF+', $decodedBody['snapshot_id']);
    }

    public function testReorderTrackFromAPlaylist(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Playlist/reorder.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->reorder('7d2D2S200NyUE5KYs80PwO', Playlist\ReorderTracks::create(1, 2));

        $decodedBody = json_decode($response->getBody(), true);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('JbtmHBDBAYu3/bt8BOXKjzKx3i0b6LCa/wVjyl6qQ2Yf6nFXkbmzuEa+ZI/U1yF+', $decodedBody['snapshot_id']);
    }

    public function testReplaceTrackFromAPlaylist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(201);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->replace('7d2D2S200NyUE5KYs80PwO', ReplaceTracks::create([
            'spotify:track:7ouMYWpwJ422jRcDASZB7P',
            'spotify:album:0eFHYz8NmK75zSplL5qlfM',
        ]));

        $this->assertSame(201, $response->getStatusCode());
    }

    public function testGetCoverFromPlaylist(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Playlist/cover.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(ImagesResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->cover('7d2D2S200NyUE5KYs80PwO');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(1, $response->getTotal());
        $this->assertContainsOnlyInstancesOf(Image::class, $response->getImages());

        /** @var \Kerox\Spotify\Model\Image $image */
        $image = $response->getImage(0);

        $this->assertSame(640, $image->getHeight());
        $this->assertSame(640, $image->getWidth());
        $this->assertSame('https://u.scdn.co/images/pl/default/438f9b65ac4eb48681351593142daeb070986293', $image->getUrl());
    }

    public function testReplaceCoverForPlaylist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->upload('7d2D2S200NyUE5KYs80PwO', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD//gA+Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcgSlBFRyB2NjIpLCBkZWZhdWx0IHF1YWxpdHkK/9sAQwAIBgYHBgUIBwcHCQkICgwUDQwLCwwZEhMPFB0aHx4dGhwcICQuJyAiLCMcHCg3KSwwMTQ0NB8nOT04MjwuMzQy/9sAQwEJCQkMCwwYDQ0YMiEcITIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIy/8AAEQgAlgCWAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A+f6KKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAP/9k=');

        $this->assertSame(200, $response->getStatusCode());
    }
}
