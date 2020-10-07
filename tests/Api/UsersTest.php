<?php

declare(strict_types=1);

namespace Tests\Kerox\Spotify\TestCase\Api;

use Kerox\Spotify\Interfaces\QueryFactoryInterface;
use Kerox\Spotify\Model\External;
use Kerox\Spotify\Model\Playlist;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\UserResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;

class UsersTest extends TestCase
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

    public function testGetAnUser(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Users/get.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(UserResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->users()->get('0123456789');

        $user = $response->getUser();

        $this->assertSame('0123456789', $user->getDisplayName());
        $this->assertContainsOnlyInstancesOf(External::class, $user->getExternalUrls());
        $this->assertNull($user->getFollowers()->getHref());
        $this->assertSame(27, $user->getFollowers()->getTotal());
        $this->assertSame('https://api.spotify.com/v1/users/0123456789', $user->getHref());
        $this->assertSame('0123456789', $user->getId());
        $this->assertEmpty($user->getImages());
        $this->assertSame('user', $user->getType());
        $this->assertSame('spotify:user:0123456789', $user->getUri());
    }

    public function testGetUserPlaylists(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Users/playlists.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(PagingResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->users()->playlists('0123456789', [
            QueryFactoryInterface::PARAMETER_LIMIT => 10,
            QueryFactoryInterface::PARAMETER_OFFSET => 5,
        ]);

        $paging = $response->getPaging();

        $this->assertContainsOnlyInstancesOf(Playlist::class, $paging->getItems());
        $this->assertInstanceOf(Playlist::class, $paging->getItem(0));
        $this->assertSame(10, $paging->getLimit());
        $this->assertSame(5, $paging->getOffset());
        $this->assertSame(6, $paging->getTotal());
        $this->assertSame(
            'https://api.spotify.com/v1/users/0123456789/playlists?offset=5&limit=10',
            $paging->getHref()
        );
        $this->assertNull($paging->getNext());
        $this->assertSame(
            'https://api.spotify.com/v1/users/0123456789/playlists?offset=0&limit=10',
            $paging->getPrevious()
        );
    }
}
