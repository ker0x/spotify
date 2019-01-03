<?php

namespace Kerox\Spotify\Test\TestCase\Api;

use Kerox\Spotify\Interfaces\QueryParametersInterface;
use Kerox\Spotify\Model\Paging;
use Kerox\Spotify\Response\SearchResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;

class SearchTest extends TestCase
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

    public function testSearch(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Search/search.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(SearchResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->search([
            QueryParametersInterface::PARAMETER_QUERY => 'Muse',
            QueryParametersInterface::PARAMETER_TYPE => [
                'track',
                'artist',
                'playlist',
                'album'
            ],
            QueryParametersInterface::PARAMETER_MARKET => 'FR',
            QueryParametersInterface::PARAMETER_LIMIT => 1,
            QueryParametersInterface::PARAMETER_OFFSET => 1,
        ]);

        $this->assertInstanceOf(Paging::class, $response->getAlbums());
        $this->assertInstanceOf(Paging::class, $response->getArtists());
        $this->assertInstanceOf(Paging::class, $response->getPlaylists());
        $this->assertInstanceOf(Paging::class, $response->getTracks());
    }
}
