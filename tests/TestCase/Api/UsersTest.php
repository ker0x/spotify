<?php

namespace Kerox\Spotify\Test\TestCase\Api;

use Kerox\Spotify\Model\External;
use Kerox\Spotify\Response\UserResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;

class UsersTest extends TestCase
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
}
