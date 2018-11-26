<?php

namespace Kerox\Spotify\Test\TestCase\Api;

use Kerox\Spotify\Interfaces\QueryParametersInterface;
use Kerox\Spotify\Model\Album;
use Kerox\Spotify\Model\Artist;
use Kerox\Spotify\Model\Copyright;
use Kerox\Spotify\Model\External;
use Kerox\Spotify\Model\Image;
use Kerox\Spotify\Model\Paging;
use Kerox\Spotify\Model\Track;
use Kerox\Spotify\Response\AlbumResponse;
use Kerox\Spotify\Response\AlbumsResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;

class AlbumsTest extends TestCase
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

    public function testGetAnAlbum(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Albums/get.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(AlbumResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->albums()->get('4aawyAB9vmqN3uQ7FjRGTy', ['market' => 'FR']);

        $album = $response->getAlbum();

        $this->assertSame('album', $album->getAlbumType());
        $this->assertContainsOnlyInstancesOf(Artist::class, $album->getArtists());
        $this->assertContainsOnlyInstancesOf(Copyright::class, $album->getCopyrights());
        $this->assertContainsOnlyInstancesOf(External::class, $album->getExternalIds());
        $this->assertContainsOnlyInstancesOf(External::class, $album->getExternalUrls());
        $this->assertSame([], $album->getGenres());
        $this->assertSame('https://api.spotify.com/v1/albums/4aawyAB9vmqN3uQ7FjRGTy', $album->getHref());
        $this->assertSame('4aawyAB9vmqN3uQ7FjRGTy', $album->getId());
        $this->assertContainsOnlyInstancesOf(Image::class, $album->getImages());
        $this->assertSame('Mr.305/Polo Grounds Music/RCA Records', $album->getLabel());
        $this->assertSame('Global Warming', $album->getName());
        $this->assertSame(59, $album->getPopularity());
        $this->assertSame('2012-11-16', $album->getReleaseDate());
        $this->assertSame('day', $album->getReleaseDatePrecision());
        $this->assertSame(18, $album->getTotalTracks());
        $this->assertInstanceOf(Paging::class, $album->getTracks());
        $this->assertSame('album', $album->getType());
        $this->assertSame('spotify:album:4aawyAB9vmqN3uQ7FjRGTy', $album->getUri());
    }

    public function testGetTracksFromAnAlbum(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Albums/tracks.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(AlbumResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->albums()->tracks('4aawyAB9vmqN3uQ7FjRGTy', [
            QueryParametersInterface::PARAMETER_MARKET => 'FR',
            QueryParametersInterface::PARAMETER_LIMIT => 10,
            QueryParametersInterface::PARAMETER_OFFSET => 5,
        ]);

        $paging = $response->getPaging();

        $this->assertSame('https://api.spotify.com/v1/albums/4aawyAB9vmqN3uQ7FjRGTy/tracks?offset=5&limit=10&market=FR',
            $paging->getHref());
        $this->assertContainsOnlyInstancesOf(Track::class, $paging->getItems());
        $this->assertInstanceOf(Track::class, $paging->getItem(1));
        $this->assertSame(10, $paging->getLimit());
        $this->assertSame('https://api.spotify.com/v1/albums/4aawyAB9vmqN3uQ7FjRGTy/tracks?offset=15&limit=10&market=FR',
            $paging->getNext());
        $this->assertSame(5, $paging->getOffset());
        $this->assertSame('https://api.spotify.com/v1/albums/4aawyAB9vmqN3uQ7FjRGTy/tracks?offset=0&limit=10&market=FR',
            $paging->getPrevious());
        $this->assertSame(18, $paging->getTotal());
    }

    public function testGetSeveralAlbums(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Albums/several.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(AlbumsResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->albums()->several([
            QueryParametersInterface::PARAMETER_IDS => [
                '382ObEPsp2rxGrnsizN5TX',
                '1A2GTWGtFfWp7KSQTwWOyo',
            ],
            QueryParametersInterface::PARAMETER_MARKET => 'FR',
        ]);

        $this->assertContainsOnlyInstancesOf(Album::class, $response->getAlbums());
        $this->assertInstanceOf(Album::class, $response->getAlbum(1));
        $this->assertNull($response->getAlbum(2));
        $this->assertSame(2, $response->getTotal());
    }
}
