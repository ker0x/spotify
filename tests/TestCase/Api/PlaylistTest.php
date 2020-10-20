<?php

declare(strict_types=1);

namespace Kerox\Spotify\Tests\TestCase\Api;

use DateTime;
use Kerox\Spotify\Interfaces\QueryParametersInterface;
use Kerox\Spotify\Model\External;
use Kerox\Spotify\Model\Followers;
use Kerox\Spotify\Model\Image;
use Kerox\Spotify\Model\Paging;
use Kerox\Spotify\Model\Playlist;
use Kerox\Spotify\Model\Playlist\AddTracks;
use Kerox\Spotify\Model\Playlist\RemoveTracks;
use Kerox\Spotify\Model\Playlist\ReorderTracks;
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

    protected function setUp(): void
    {
        $this->oauthToken = 'BQCpTK7nCpmijQURqGm-hBvOgS4T--ql1zfbiBVYwbzFb4z06fP8pFvLoiDSjSNawQEfRahU3pCJOQJIyhvi1JcmQtLJ_Oh-p3vKWhEfesG-UcIF_tPBjGRSn1Xu1w0QIbrvN9RnSm2-EI_NeNEOBxBHTlviYhq128bjG4obEeemHMIyAE2dJPIwumC-XPqfjXwkUGOVyfu5BJqERSVcT65m-g0xu9T52Q1RpJfvm5J0nGZw5Z647IEucZjqavtWycL2YnXLd02tSt9E0YY';
    }

    protected function tearDown(): void
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
        $response = $spotify->playlists()->get('3cEYpjA9oz9GiPac4AsH4n');

        $playlist = $response->getPlaylist();

        self::assertFalse($playlist->isCollaborative());
        self::assertSame('A playlist for testing pourposes', $playlist->getDescription());
        self::assertContainsOnlyInstancesOf(External::class, $playlist->getExternalUrls());
        self::assertInstanceOf(Followers::class, $playlist->getFollowers());
        self::assertSame('https://api.spotify.com/v1/playlists/3cEYpjA9oz9GiPac4AsH4n', $playlist->getHref());
        self::assertSame('3cEYpjA9oz9GiPac4AsH4n', $playlist->getId());
        self::assertContainsOnlyInstancesOf(Image::class, $playlist->getImages());
        self::assertSame('Spotify Web API Testing playlist', $playlist->getName());
        self::assertInstanceOf(User::class, $playlist->getOwner());
        self::assertNull($playlist->getPrimaryColor());
        self::assertTrue($playlist->isPublic());
        self::assertSame('MTcsZDhlNTBiODE0ZTExZDExYjM4NGFlZmFlOTQ1NGE1NTk3ZjNmM2RmOQ==', $playlist->getSnapshotId());
        self::assertInstanceOf(Paging::class, $playlist->getTracks());
        self::assertInstanceOf(SavedTrack::class, $playlist->getTracks()->getItem(0));
        self::assertSame('playlist', $playlist->getType());
        self::assertSame('spotify:user:jmperezperez:playlist:3cEYpjA9oz9GiPac4AsH4n', $playlist->getUri());

        /* @var \Kerox\Spotify\Model\SavedTrack $savedTrack */
        $savedTrack = $playlist->getTracks()->getItem(0);

        self::assertInstanceOf(DateTime::class, $savedTrack->getAddedAt());
        self::assertInstanceOf(User::class, $savedTrack->getAddedBy());
        self::assertFalse($savedTrack->isLocal());
        self::assertNull($savedTrack->getPrimaryColor());
        self::assertInstanceOf(TrackLink::class, $savedTrack->getTrack()->getLinkedFrom());
        self::assertContainsOnlyInstancesOf(External::class, $savedTrack->getVideoThumbnail());

        /* @var \Kerox\Spotify\Model\TrackLink $trackLink */
        $trackLink = $savedTrack->getTrack()->getLinkedFrom();
        self::assertContainsOnlyInstancesOf(External::class, $trackLink->getExternalUrls());
        self::assertSame('https://api.spotify.com/v1/tracks/5o3jMYOSbaVz3tkgwhELSV', $trackLink->getHref());
        self::assertSame('5o3jMYOSbaVz3tkgwhELSV', $trackLink->getId());
        self::assertSame('track', $trackLink->getType());
        self::assertSame('spotify:track:5o3jMYOSbaVz3tkgwhELSV', $trackLink->getUri());
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

        self::assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=5&limit=10',
            $paging->getHref());
        self::assertContainsOnlyInstancesOf(Playlist::class, $paging->getItems());
        self::assertSame(10, $paging->getLimit());
        self::assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=15&limit=10',
            $paging->getNext());
        self::assertSame(5, $paging->getOffset());
        self::assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=0&limit=10',
            $paging->getPrevious());
        self::assertSame(43, $paging->getTotal());
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

        self::assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=5&limit=10',
            $paging->getHref());
        self::assertContainsOnlyInstancesOf(Playlist::class, $paging->getItems());
        self::assertSame(10, $paging->getLimit());
        self::assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=15&limit=10',
            $paging->getNext());
        self::assertSame(5, $paging->getOffset());
        self::assertSame('https://api.spotify.com/v1/users/1199545168/playlists?offset=0&limit=10',
            $paging->getPrevious());
        self::assertSame(43, $paging->getTotal());
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

        self::assertSame('https://api.spotify.com/v1/playlists/37i9dQZF1DWVFJtzvDHN4L/tracks?offset=0&limit=1&market=FR',
            $paging->getHref());
        self::assertContainsOnlyInstancesOf(SavedTrack::class, $paging->getItems());
        self::assertSame(1, $paging->getLimit());
        self::assertSame('https://api.spotify.com/v1/playlists/37i9dQZF1DWVFJtzvDHN4L/tracks?offset=1&limit=1&market=FR',
            $paging->getNext());
        self::assertSame(0, $paging->getOffset());
        self::assertNull($paging->getPrevious());
        self::assertSame(50, $paging->getTotal());
    }

    public function testFollowPlaylist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->follow('37i9dQZF1DWVFJtzvDHN4L');

        self::assertSame(200, $response->getStatusCode());
    }

    public function testUnfollowPlaylist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->unfollow('37i9dQZF1DWVFJtzvDHN4L');

        self::assertSame(200, $response->getStatusCode());
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

        self::assertSame(201, $response->getStatusCode());
        self::assertInstanceOf(Playlist::class, $response->getPlaylist());
    }

    public function testUpdateAPlaylist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->update('7d2D2S200NyUE5KYs80PwO', Playlist::create('A New Update Playlist', false, false, 'A new awesome update playlist'));

        self::assertSame(200, $response->getStatusCode());
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

        $decodedBody = json_decode((string) $response->getBody(), true);

        self::assertSame(201, $response->getStatusCode());
        self::assertSame('JbtmHBDBAYu3/bt8BOXKjzKx3i0b6LCa/wVjyl6qQ2Yf6nFXkbmzuEa+ZI/U1yF+', $decodedBody['snapshot_id']);
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

        $decodedBody = json_decode((string) $response->getBody(), true);

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('jzKx3i0b6LCaJbtmHBDBAYu3/bt8BOXK/wVjyl6qQ2Yf6nFXkbmzuEa+ZI/U1yF+', $decodedBody['snapshot_id']);
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

        $reorderTrack = ReorderTracks::create(1, 2)
            ->setRangeLength(3)
            ->setSnapshotId('jzKx3i0b6LCaJbtmHBDBAYu3bt8BOXKwVjyl6qQ2Yf6nFXkbmzuEa+ZIU1yF+');

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->reorder('7d2D2S200NyUE5KYs80PwO', $reorderTrack);

        $decodedBody = json_decode((string) $response->getBody(), true);

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('JbtmHBDBAYu3/bt8BOXKjzKx3i0b6LCa/wVjyl6qQ2Yf6nFXkbmzuEa+ZI/U1yF+', $decodedBody['snapshot_id']);
    }

    public function testReplaceTrackFromAPlaylist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(201);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $replaceTrack = ReplaceTracks::create([
            'spotify:track:7ouMYWpwJ422jRcDASZB7P',
            'spotify:track:0eFHYz8NmK75zSplL5qlfM',
        ])->add('spotify:track:4VqPOruhp5EdPBeR92t6lQ');

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->replace('7d2D2S200NyUE5KYs80PwO', $replaceTrack);

        self::assertSame(201, $response->getStatusCode());
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

        self::assertSame(200, $response->getStatusCode());
        self::assertSame(1, $response->getTotal());
        self::assertContainsOnlyInstancesOf(Image::class, $response->getImages());

        /** @var \Kerox\Spotify\Model\Image $image */
        $image = $response->getImage(0);

        self::assertSame(640, $image->getHeight());
        self::assertSame(640, $image->getWidth());
        self::assertSame('https://u.scdn.co/images/pl/default/438f9b65ac4eb48681351593142daeb070986293', $image->getUrl());
    }

    public function testReplaceCoverForPlaylist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->playlists()->upload('7d2D2S200NyUE5KYs80PwO', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD//gA+Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcgSlBFRyB2NjIpLCBkZWZhdWx0IHF1YWxpdHkK/9sAQwAIBgYHBgUIBwcHCQkICgwUDQwLCwwZEhMPFB0aHx4dGhwcICQuJyAiLCMcHCg3KSwwMTQ0NB8nOT04MjwuMzQy/9sAQwEJCQkMCwwYDQ0YMiEcITIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIy/8AAEQgAlgCWAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A+f6KKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAP/9k=');

        self::assertSame(200, $response->getStatusCode());
    }
}
