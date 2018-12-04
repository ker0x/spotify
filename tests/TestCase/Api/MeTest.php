<?php

namespace Kerox\Spotify\Test\TestCase\Api;

use Kerox\Spotify\Interfaces\QueryParametersInterface;
use Kerox\Spotify\Interfaces\TypeInterface;
use Kerox\Spotify\Model\Artist;
use Kerox\Spotify\Model\External;
use Kerox\Spotify\Model\Image;
use Kerox\Spotify\Model\Playlist;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\UserResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class MeTest extends TestCase
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
        $response = $spotify->me()->playlists([
            QueryParametersInterface::PARAMETER_LIMIT => 10,
            QueryParametersInterface::PARAMETER_OFFSET => 5,
        ]);

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
        $response = $spotify->me()->top(TypeInterface::TYPE_ARTISTS, [
            QueryParametersInterface::PARAMETER_TIME_RANGE => 'medium_term',
            QueryParametersInterface::PARAMETER_LIMIT => 10,
            QueryParametersInterface::PARAMETER_OFFSET => 5,
        ]);

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
        $response = $spotify->me()->follow([
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
        $response = $spotify->me()->unfollow([
            '2CIMQHirSU0MQqyYHq0eOx',
            '57dN52uHvrHOxijzpIgu3E',
            '1vCWHaC5f2uS3yhpwWbIA6',
        ]);

        $this->assertSame(200, $response->getStatusCode());
    }
}
