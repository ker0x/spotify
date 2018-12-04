<?php

namespace Kerox\Spotify\Test\TestCase\Api;

use Kerox\Spotify\Interfaces\QueryParametersInterface;
use Kerox\Spotify\Model\Album;
use Kerox\Spotify\Model\Artist;
use Kerox\Spotify\Model\External;
use Kerox\Spotify\Model\Track;
use Kerox\Spotify\Model\TrackLink;
use Kerox\Spotify\Response\TrackResponse;
use Kerox\Spotify\Response\TracksResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;

class TracksTest extends TestCase
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

    public function testGetATrack(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Tracks/single-track.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(TrackResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->tracks()->get('0tGPJ0bkWOUmH7MEOR77qc', [
            QueryParametersInterface::PARAMETER_MARKET => 'FR'
        ]);

        $track = $response->getTrack();

        $this->assertInstanceOf(Album::class, $track->getAlbum());
        $this->assertContainsOnlyInstancesOf(Artist::class, $track->getArtists());
        $this->assertSame(1, $track->getDiscNumber());
        $this->assertSame(207959, $track->getDurationMs());
        $this->assertFalse($track->isExplicit());
        $this->assertContainsOnlyInstancesOf(External::class, $track->getExternalIds());
        $this->assertContainsOnlyInstancesOf(External::class, $track->getExternalUrls());
        $this->assertSame('https://api.spotify.com/v1/tracks/6EJiVf7U0p1BBfs0qqeb1f', $track->getHref());
        $this->assertSame('6EJiVf7U0p1BBfs0qqeb1f', $track->getId());
        $this->assertFalse($track->isLocal());
        $this->assertTrue($track->isPlayable());
        $this->assertInstanceOf(TrackLink::class, $track->getLinkedFrom());
        $this->assertSame('Cut To The Feeling', $track->getName());
        $this->assertSame(65, $track->getPopularity());
        $this->assertSame('https://p.scdn.co/mp3-preview/229bb6a4c7011158cc7e1aff11957e274dc05e84?cid=774b29d4f13844c495f206cafdad9c86', $track->getPreviewUrl());
        $this->assertSame(1, $track->getTrackNumber());
        $this->assertSame('track', $track->getType());
        $this->assertSame('spotify:track:6EJiVf7U0p1BBfs0qqeb1f', $track->getUri());
    }

    public function testGetSeveralTracks(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Tracks/multiple-tracks.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(TracksResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->tracks()->several([
            QueryParametersInterface::PARAMETER_IDS => [
                '7ouMYWpwJ422jRcDASZB7P',
                '4VqPOruhp5EdPBeR92t6lQ',
                '2takcwOaAZWiXQijPHIx7B',
            ],
            QueryParametersInterface::PARAMETER_MARKET => 'FR',
        ]);

        $this->assertContainsOnlyInstancesOf(Track::class, $response->getTracks());
        $this->assertInstanceOf(Track::class, $response->getTrack(1));
        $this->assertNull($response->getTrack(3));
        $this->assertSame(3, $response->getTotal());
    }
}
