<?php

declare(strict_types=1);

namespace Kerox\Spotify\Tests\TestCase\Api;

use DateTime;
use Kerox\Spotify\Interfaces\QueryParametersInterface;
use Kerox\Spotify\Model\Album;
use Kerox\Spotify\Model\Artist;
use Kerox\Spotify\Model\Copyright;
use Kerox\Spotify\Model\External;
use Kerox\Spotify\Model\Image;
use Kerox\Spotify\Model\Paging;
use Kerox\Spotify\Model\SavedAlbum;
use Kerox\Spotify\Model\Track;
use Kerox\Spotify\Response\AlbumResponse;
use Kerox\Spotify\Response\AlbumsResponse;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class AlbumsTest extends TestCase
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
        $response = $spotify->albums()->get('4aawyAB9vmqN3uQ7FjRGTy', [
            QueryParametersInterface::PARAMETER_MARKET => 'FR',
        ]);

        $album = $response->getAlbum();

        self::assertSame('album', $album->getAlbumType());
        self::assertContainsOnlyInstancesOf(Artist::class, $album->getArtists());
        self::assertEmpty($album->getAvailableMarkets());
        self::assertContainsOnlyInstancesOf(Copyright::class, $album->getCopyrights());
        self::assertSame('(P) 2012 RCA Records, a division of Sony Music Entertainment', $album->getCopyrights()[0]->getText());
        self::assertSame('P', $album->getCopyrights()[0]->getType());
        self::assertContainsOnlyInstancesOf(External::class, $album->getExternalIds());
        self::assertSame('upc', $album->getExternalIds()[0]->getType());
        self::assertSame('886443671584', $album->getExternalIds()[0]->getValue());
        self::assertContainsOnlyInstancesOf(External::class, $album->getExternalUrls());
        self::assertSame('spotify', $album->getExternalUrls()[0]->getType());
        self::assertSame('https://open.spotify.com/album/4aawyAB9vmqN3uQ7FjRGTy', $album->getExternalUrls()[0]->getValue());
        self::assertSame([], $album->getGenres());
        self::assertSame('https://api.spotify.com/v1/albums/4aawyAB9vmqN3uQ7FjRGTy', $album->getHref());
        self::assertSame('4aawyAB9vmqN3uQ7FjRGTy', $album->getId());
        self::assertContainsOnlyInstancesOf(Image::class, $album->getImages());
        self::assertSame('https://i.scdn.co/image/3edb3f970f4a3af9ef922efd18cdb4dabaf85ced', $album->getImages()[0]->getUrl());
        self::assertSame(640, $album->getImages()[0]->getHeight());
        self::assertSame(640, $album->getImages()[0]->getWidth());
        self::assertSame('Mr.305/Polo Grounds Music/RCA Records', $album->getLabel());
        self::assertSame('Global Warming', $album->getName());
        self::assertSame(59, $album->getPopularity());
        self::assertSame('2012-11-16', $album->getReleaseDate());
        self::assertSame('day', $album->getReleaseDatePrecision());
        self::assertSame(18, $album->getTotalTracks());
        self::assertInstanceOf(Paging::class, $album->getTracks());
        self::assertSame('album', $album->getType());
        self::assertSame('spotify:album:4aawyAB9vmqN3uQ7FjRGTy', $album->getUri());
        self::assertNull($album->getRestrictions());
        self::assertNull($album->getAlbumGroup());
    }

    public function testGetTracksFromAnAlbum(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Albums/tracks.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(PagingResponse::class);
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

        self::assertContainsOnlyInstancesOf(Track::class, $paging->getItems());
        self::assertInstanceOf(Track::class, $paging->getItem(1));
        self::assertSame(10, $paging->getLimit());
        self::assertSame(5, $paging->getOffset());
        self::assertSame(18, $paging->getTotal());
        self::assertSame(
            'https://api.spotify.com/v1/albums/4aawyAB9vmqN3uQ7FjRGTy/tracks?offset=5&limit=10&market=FR',
            $paging->getHref()
        );
        self::assertSame(
            'https://api.spotify.com/v1/albums/4aawyAB9vmqN3uQ7FjRGTy/tracks?offset=15&limit=10&market=FR',
            $paging->getNext()
        );
        self::assertSame(
            'https://api.spotify.com/v1/albums/4aawyAB9vmqN3uQ7FjRGTy/tracks?offset=0&limit=10&market=FR',
            $paging->getPrevious()
        );
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

        self::assertContainsOnlyInstancesOf(Album::class, $response->getAlbums());
        self::assertInstanceOf(Album::class, $response->getAlbum(1));
        self::assertNull($response->getAlbum(2));
        self::assertSame(2, $response->getTotal());
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
        $response = $spotify->albums()->saved([
            QueryParametersInterface::PARAMETER_LIMIT => 2,
            QueryParametersInterface::PARAMETER_OFFSET => 0,
        ]);

        $paging = $response->getPaging();

        self::assertSame('https://api.spotify.com/v1/me/albums?offset=0&limit=2', $paging->getHref());
        self::assertInstanceOf(SavedAlbum::class, $paging->getItem(0));
        self::assertSame(2, $paging->getLimit());
        self::assertSame('https://api.spotify.com/v1/me/albums?offset=2&limit=2', $paging->getNext());
        self::assertSame(0, $paging->getOffset());
        self::assertNull($paging->getPrevious());
        self::assertSame(3, $paging->getTotal());

        /** @var \Kerox\Spotify\Model\SavedAlbum $savedAlbum */
        $savedAlbum = $paging->getItem(0);

        self::assertInstanceOf(DateTime::class, $savedAlbum->getAddedAt());
        self::assertInstanceOf(Album::class, $savedAlbum->getAlbum());
    }

    public function testAddAlbumsForCurrentUser(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(201);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->albums()->add([
            QueryParametersInterface::PARAMETER_IDS => [
                '07bYtmE3bPsLB6ZbmmFi8d',
                '48JYNjh7GMie6NjqYHMmtT',
                '27cZdqrQiKt3IT00338dws',
            ],
        ]);

        self::assertSame(201, $response->getStatusCode());
    }

    public function testDeleteAlbumsForCurrentUser(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->albums()->remove([
            QueryParametersInterface::PARAMETER_IDS => [
                '07bYtmE3bPsLB6ZbmmFi8d',
                '48JYNjh7GMie6NjqYHMmtT',
                '27cZdqrQiKt3IT00338dws',
            ],
        ]);

        self::assertSame(200, $response->getStatusCode());
    }
}
