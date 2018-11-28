<?php

namespace Kerox\Spotify\Test\TestCase\Api;

use Kerox\Spotify\Interfaces\QueryParametersInterface;
use Kerox\Spotify\Interfaces\TypeInterface;
use Kerox\Spotify\Response\FollowingResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class FollowTest extends TestCase
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

    public function testFollowing(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Follow/contains.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(FollowingResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->follow()->following([
            QueryParametersInterface::PARAMETER_TYPE => TypeInterface::TYPE_ARTIST,
            QueryParametersInterface::PARAMETER_IDS => [
                '2CIMQHirSU0MQqyYHq0eOx',
                '57dN52uHvrHOxijzpIgu3E',
                '1vCWHaC5f2uS3yhpwWbIA6',
            ]
        ]);

        $this->assertFalse($response->isFollowing('2CIMQHirSU0MQqyYHq0eOx'));
        $this->assertTrue($response->isFollowing('57dN52uHvrHOxijzpIgu3E'));
        $this->assertFalse($response->isFollowing('1vCWHaC5f2uS3yhpwWbIA6'));
    }

    public function testFollow(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->follow()->add([
            QueryParametersInterface::PARAMETER_TYPE => TypeInterface::TYPE_ARTIST,
            QueryParametersInterface::PARAMETER_IDS => [
                '2CIMQHirSU0MQqyYHq0eOx',
                '57dN52uHvrHOxijzpIgu3E',
                '1vCWHaC5f2uS3yhpwWbIA6',
            ]
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
        $response = $spotify->follow()->delete([
            QueryParametersInterface::PARAMETER_TYPE => TypeInterface::TYPE_ARTIST,
            QueryParametersInterface::PARAMETER_IDS => [
                '2CIMQHirSU0MQqyYHq0eOx',
                '57dN52uHvrHOxijzpIgu3E',
                '1vCWHaC5f2uS3yhpwWbIA6',
            ]
        ]);

        $this->assertSame(200, $response->getStatusCode());
    }
}