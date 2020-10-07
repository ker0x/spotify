<?php

declare(strict_types=1);

namespace Tests\Kerox\Spotify\TestCase\Api;

use DateTime;
use Kerox\Spotify\Factory\QueryFactory;
use Kerox\Spotify\Interfaces\TypeInterface;
use Kerox\Spotify\Model\Album;
use Kerox\Spotify\Model\Artist;
use Kerox\Spotify\Model\Cursor;
use Kerox\Spotify\Model\External;
use Kerox\Spotify\Model\Image;
use Kerox\Spotify\Model\Playlist;
use Kerox\Spotify\Model\SavedAlbum;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\UserFollowingResponse;
use Kerox\Spotify\Response\UserResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class MeTest extends TestCase
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

    public function testGetMe(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Me/get.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(UserResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->me()->getProfile();

        $user = $response->getUser();

        $this->assertSame('1988-01-06', $user->getBirthDate());
        $this->assertSame('FR', $user->getCountry());
        $this->assertSame('Romain Monteil', $user->getDisplayName());
        $this->assertSame('monteil.romain@gmail.com', $user->getEmail());
        $this->assertContainsOnlyInstancesOf(External::class, $user->getExternalUrls());
        $this->assertNull($user->getFollowers()->getHref());
        $this->assertSame(6, $user->getFollowers()->getTotal());
        $this->assertSame('https://api.spotify.com/v1/users/1199545168', $user->getHref());
        $this->assertSame('1199545168', $user->getId());
        $this->assertContainsOnlyInstancesOf(Image::class, $user->getImages());
        $this->assertSame('https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/31964231_10156960367129386_5965686321191059456_n.jpg?_nc_cat=100&_nc_ht=scontent.xx&oh=8f737862131b5df5b2b469c454763434&oe=5C9F532F',
            $user->getImages()[0]->getUrl());
        $this->assertNull($user->getImages()[0]->getHeight());
        $this->assertNull($user->getImages()[0]->getWidth());
        $this->assertSame('premium', $user->getProduct());
        $this->assertSame('user', $user->getType());
        $this->assertSame('spotify:user:1199545168', $user->getUri());
    }

    public function testGetMePlaylists(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Me/playlists.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(PagingResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->me()->getPlaylists((new QueryFactory())->setLimit(10)->setOffset(5));

        $paging = $response->getPaging();

        $this->assertContainsOnlyInstancesOf(Playlist::class, $paging->getItems());
        $this->assertInstanceOf(Playlist::class, $paging->getItem(1));
        $this->assertSame(10, $paging->getLimit());
        $this->assertSame(5, $paging->getOffset());
        $this->assertSame(43, $paging->getTotal());
        $this->assertSame(
            'https://api.spotify.com/v1/users/1199545168/playlists?offset=5&limit=10',
            $paging->getHref()
        );
        $this->assertSame(
            'https://api.spotify.com/v1/users/1199545168/playlists?offset=15&limit=10',
            $paging->getNext()
        );
        $this->assertSame(
            'https://api.spotify.com/v1/users/1199545168/playlists?offset=0&limit=10',
            $paging->getPrevious()
        );
    }

    public function testGetTop(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Me/top.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(PagingResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->me()->getTop(TypeInterface::TYPE_ARTISTS, (new QueryFactory())
            ->setTimeRange()
            ->setLimit(10)
            ->setOffset(5)
        );

        $paging = $response->getPaging();

        $this->assertContainsOnlyInstancesOf(Artist::class, $paging->getItems());
        $this->assertInstanceOf(Artist::class, $paging->getItem(1));
        $this->assertSame(10, $paging->getLimit());
        $this->assertSame(5, $paging->getOffset());
        $this->assertSame(50, $paging->getTotal());
        $this->assertSame('https://api.spotify.com/v1/me/top/artists?limit=10&offset=5', $paging->getHref());
        $this->assertSame('https://api.spotify.com/v1/me/top/artists?limit=10&offset=15', $paging->getNext());
        $this->assertNull($paging->getPrevious());
    }

    public function testFollow(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->me()->followArtists([
            '2CIMQHirSU0MQqyYHq0eOx',
            '57dN52uHvrHOxijzpIgu3E',
            '1vCWHaC5f2uS3yhpwWbIA6',
        ]);

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testUnfollow(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->me()->unfollowArtists([
            '2CIMQHirSU0MQqyYHq0eOx',
            '57dN52uHvrHOxijzpIgu3E',
            '1vCWHaC5f2uS3yhpwWbIA6',
        ]);

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testFollowing(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Me/following.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(UserFollowingResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->me()->getFollowing((new QueryFactory())
            ->setType('artist')
            ->setAfter('0I2XqVXqHScXjHhk6AYYRe')
            ->setLimit(1)
        );

        $this->assertContainsOnlyInstancesOf(Artist::class, $response->getArtists()->getItems());
        $this->assertSame('https://api.spotify.com/v1/me/following?type=artist&after=0bRtSoJSpQdnbB3dWrWprR&limit=10', $response->getArtists()->getNext());
        $this->assertSame(174, $response->getArtists()->getTotal());
        $this->assertInstanceOf(Cursor::class, $response->getArtists()->getCursors());
        $this->assertSame('0bRtSoJSpQdnbB3dWrWprR', $response->getArtists()->getCursors()->getAfter());
        $this->assertSame(10, $response->getArtists()->getLimit());
        $this->assertSame('https://api.spotify.com/v1/me/following?type=artist&after=0I2XqVXqHScXjHhk6AYYRe&limit=10', $response->getArtists()->getHref());
    }

    public function testGetAlbumsForCurrentUser(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Albums/saved.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(PagingResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->me()->getSavedAlbums((new QueryFactory())->setLimit(2)->setOffset(0));

        $paging = $response->getPaging();

        $this->assertSame('https://api.spotify.com/v1/me/albums?offset=0&limit=2', $paging->getHref());
        $this->assertInstanceOf(SavedAlbum::class, $paging->getItem(0));
        $this->assertSame(2, $paging->getLimit());
        $this->assertSame('https://api.spotify.com/v1/me/albums?offset=2&limit=2', $paging->getNext());
        $this->assertSame(0, $paging->getOffset());
        $this->assertNull($paging->getPrevious());
        $this->assertSame(3, $paging->getTotal());

        /** @var \Kerox\Spotify\Model\SavedAlbum $savedAlbum */
        $savedAlbum = $paging->getItem(0);

        $this->assertInstanceOf(DateTime::class, $savedAlbum->getAddedAt());
        $this->assertInstanceOf(Album::class, $savedAlbum->getAlbum());
    }

    public function testAddAlbumsForCurrentUser(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(201);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->me()->addAlbums((new QueryFactory())->setIds([
            '07bYtmE3bPsLB6ZbmmFi8d',
            '48JYNjh7GMie6NjqYHMmtT',
            '27cZdqrQiKt3IT00338dws',
        ]));

        $this->assertSame(201, $response->getStatusCode());
    }

    public function testDeleteAlbumsForCurrentUser(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->me()->deleteAlbums((new QueryFactory())->setIds([
            '07bYtmE3bPsLB6ZbmmFi8d',
            '48JYNjh7GMie6NjqYHMmtT',
            '27cZdqrQiKt3IT00338dws',
        ]));

        $this->assertSame(200, $response->getStatusCode());
    }
}
