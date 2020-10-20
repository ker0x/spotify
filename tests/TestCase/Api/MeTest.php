<?php

declare(strict_types=1);

namespace Kerox\Spotify\Tests\TestCase\Api;

use Kerox\Spotify\Interfaces\QueryParametersInterface;
use Kerox\Spotify\Interfaces\TypeInterface;
use Kerox\Spotify\Model\Artist;
use Kerox\Spotify\Model\Cursor;
use Kerox\Spotify\Model\External;
use Kerox\Spotify\Model\Image;
use Kerox\Spotify\Model\Playlist;
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
        $response = $spotify->me()->get();

        $user = $response->getUser();

        self::assertSame('1988-01-06', $user->getBirthDate());
        self::assertSame('FR', $user->getCountry());
        self::assertSame('Romain Monteil', $user->getDisplayName());
        self::assertSame('monteil.romain@gmail.com', $user->getEmail());
        self::assertContainsOnlyInstancesOf(External::class, $user->getExternalUrls());
        self::assertNull($user->getFollowers()->getHref());
        self::assertSame(6, $user->getFollowers()->getTotal());
        self::assertSame('https://api.spotify.com/v1/users/1199545168', $user->getHref());
        self::assertSame('1199545168', $user->getId());
        self::assertContainsOnlyInstancesOf(Image::class, $user->getImages());
        self::assertSame('https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/31964231_10156960367129386_5965686321191059456_n.jpg?_nc_cat=100&_nc_ht=scontent.xx&oh=8f737862131b5df5b2b469c454763434&oe=5C9F532F',
            $user->getImages()[0]->getUrl());
        self::assertNull($user->getImages()[0]->getHeight());
        self::assertNull($user->getImages()[0]->getWidth());
        self::assertSame('premium', $user->getProduct());
        self::assertSame('user', $user->getType());
        self::assertSame('spotify:user:1199545168', $user->getUri());
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
        $response = $spotify->me()->playlists([
            QueryParametersInterface::PARAMETER_LIMIT => 10,
            QueryParametersInterface::PARAMETER_OFFSET => 5,
        ]);

        $paging = $response->getPaging();

        self::assertContainsOnlyInstancesOf(Playlist::class, $paging->getItems());
        self::assertInstanceOf(Playlist::class, $paging->getItem(1));
        self::assertSame(10, $paging->getLimit());
        self::assertSame(5, $paging->getOffset());
        self::assertSame(43, $paging->getTotal());
        self::assertSame(
            'https://api.spotify.com/v1/users/1199545168/playlists?offset=5&limit=10',
            $paging->getHref()
        );
        self::assertSame(
            'https://api.spotify.com/v1/users/1199545168/playlists?offset=15&limit=10',
            $paging->getNext()
        );
        self::assertSame(
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
        $response = $spotify->me()->top(TypeInterface::TYPE_ARTISTS, [
            QueryParametersInterface::PARAMETER_TIME_RANGE => 'medium_term',
            QueryParametersInterface::PARAMETER_LIMIT => 10,
            QueryParametersInterface::PARAMETER_OFFSET => 5,
        ]);

        $paging = $response->getPaging();

        self::assertContainsOnlyInstancesOf(Artist::class, $paging->getItems());
        self::assertInstanceOf(Artist::class, $paging->getItem(1));
        self::assertSame(10, $paging->getLimit());
        self::assertSame(5, $paging->getOffset());
        self::assertSame(50, $paging->getTotal());
        self::assertSame('https://api.spotify.com/v1/me/top/artists?limit=10&offset=5', $paging->getHref());
        self::assertSame('https://api.spotify.com/v1/me/top/artists?limit=10&offset=15', $paging->getNext());
        self::assertNull($paging->getPrevious());
    }

    public function testFollow(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->me()->follow([
            '2CIMQHirSU0MQqyYHq0eOx',
            '57dN52uHvrHOxijzpIgu3E',
            '1vCWHaC5f2uS3yhpwWbIA6',
        ]);

        self::assertSame(200, $response->getStatusCode());
    }

    public function testUnfollow(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->me()->unfollow([
            '2CIMQHirSU0MQqyYHq0eOx',
            '57dN52uHvrHOxijzpIgu3E',
            '1vCWHaC5f2uS3yhpwWbIA6',
        ]);

        self::assertSame(200, $response->getStatusCode());
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
        $response = $spotify->me()->following([
            QueryParametersInterface::PARAMETER_TYPE => [
                'artist',
            ],
            QueryParametersInterface::PARAMETER_AFTER => '0I2XqVXqHScXjHhk6AYYRe',
            QueryParametersInterface::PARAMETER_LIMIT => 1,
        ]);

        self::assertContainsOnlyInstancesOf(Artist::class, $response->getArtists()->getItems());
        self::assertSame('https://api.spotify.com/v1/me/following?type=artist&after=0bRtSoJSpQdnbB3dWrWprR&limit=10', $response->getArtists()->getNext());
        self::assertSame(174, $response->getArtists()->getTotal());
        self::assertInstanceOf(Cursor::class, $response->getArtists()->getCursors());
        self::assertSame('0bRtSoJSpQdnbB3dWrWprR', $response->getArtists()->getCursors()->getAfter());
        self::assertSame(10, $response->getArtists()->getLimit());
        self::assertSame('https://api.spotify.com/v1/me/following?type=artist&after=0I2XqVXqHScXjHhk6AYYRe&limit=10', $response->getArtists()->getHref());
    }
}
