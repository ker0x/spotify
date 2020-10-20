<?php

declare(strict_types=1);

namespace Kerox\Spotify\Tests\TestCase\Api;

use Kerox\Spotify\Interfaces\QueryParametersInterface;
use Kerox\Spotify\Model\Album;
use Kerox\Spotify\Model\Artist;
use Kerox\Spotify\Model\External;
use Kerox\Spotify\Model\Followers;
use Kerox\Spotify\Model\Image;
use Kerox\Spotify\Model\Track;
use Kerox\Spotify\Response\ArtistResponse;
use Kerox\Spotify\Response\ArtistsResponse;
use Kerox\Spotify\Response\PagingResponse;
use Kerox\Spotify\Response\TracksResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ArtistsTest extends TestCase
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

    public function testGetAnArtist(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Artists/get.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(ArtistResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->artists()->get('0TnOYISbd1XYRBk9myaseg');

        $artist = $response->getArtist();

        self::assertContainsOnlyInstancesOf(External::class, $artist->getExternalUrls());
        self::assertInstanceOf(Followers::class, $artist->getFollowers());
        self::assertNull($artist->getFollowers()->getHref());
        self::assertSame(6406754, $artist->getFollowers()->getTotal());
        self::assertSame(['dance pop', 'latin', 'pop', 'pop rap'], $artist->getGenres());
        self::assertSame('https://api.spotify.com/v1/artists/0TnOYISbd1XYRBk9myaseg', $artist->getHref());
        self::assertSame('0TnOYISbd1XYRBk9myaseg', $artist->getId());
        self::assertContainsOnlyInstancesOf(Image::class, $artist->getImages());
        self::assertSame('Pitbull', $artist->getName());
        self::assertSame(82, $artist->getPopularity());
        self::assertSame('artist', $artist->getType());
        self::assertSame('spotify:artist:0TnOYISbd1XYRBk9myaseg', $artist->getUri());
    }

    public function testGetAlbums(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Artists/albums.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(PagingResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->artists()->albums('0TnOYISbd1XYRBk9myaseg', [
            QueryParametersInterface::PARAMETER_INCLUDE_GROUPS => [
                QueryParametersInterface::INCLUDE_GROUPS_SINGLE,
                QueryParametersInterface::INCLUDE_GROUPS_APPEARS_ON,
            ],
            QueryParametersInterface::PARAMETER_MARKET => 'FR',
            QueryParametersInterface::PARAMETER_LIMIT => 10,
            QueryParametersInterface::PARAMETER_OFFSET => 5,
        ]);

        $paging = $response->getPaging();

        self::assertSame('https://api.spotify.com/v1/artists/0TnOYISbd1XYRBk9myaseg/albums?offset=5&limit=10&include_groups=single,appears_on&market=FR',
            $paging->getHref());
        self::assertContainsOnlyInstancesOf(Album::class, $paging->getItems());
        self::assertInstanceOf(Album::class, $paging->getItem(1));
        self::assertSame(10, $paging->getLimit());
        self::assertSame('https://api.spotify.com/v1/artists/0TnOYISbd1XYRBk9myaseg/albums?offset=15&limit=10&include_groups=single,appears_on&market=FR',
            $paging->getNext());
        self::assertSame(5, $paging->getOffset());
        self::assertSame('https://api.spotify.com/v1/artists/0TnOYISbd1XYRBk9myaseg/albums?offset=0&limit=10&include_groups=single,appears_on&market=FR',
            $paging->getPrevious());
        self::assertSame(487, $paging->getTotal());
    }

    public function testGetTopTracks(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Artists/top-tracks.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(TracksResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->artists()->topTracks('0TnOYISbd1XYRBk9myaseg', [
            QueryParametersInterface::PARAMETER_MARKET => 'FR',
        ]);

        self::assertContainsOnlyInstancesOf(Track::class, $response->getTracks());
        self::assertInstanceOf(Track::class, $response->getTrack(1));
        self::assertSame(10, $response->getTotal());
    }

    public function testGetRelatedArtists(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Artists/related-artists.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(ArtistsResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->artists()->related('0TnOYISbd1XYRBk9myaseg');

        self::assertContainsOnlyInstancesOf(Artist::class, $response->getArtists());
        self::assertInstanceOf(Artist::class, $response->getArtist(1));
        self::assertSame(20, $response->getTotal());
    }

    public function testGetSeveral(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Artists/several.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(ArtistsResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->artists()->several([
            QueryParametersInterface::PARAMETER_IDS => [
                '2CIMQHirSU0MQqyYHq0eOx',
                '57dN52uHvrHOxijzpIgu3E',
            ],
        ]);

        self::assertContainsOnlyInstancesOf(Artist::class, $response->getArtists());
        self::assertInstanceOf(Artist::class, $response->getArtist(1));
        self::assertSame(2, $response->getTotal());
    }

    public function testFollowArtist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(204);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->artists()->follow([
            '2CIMQHirSU0MQqyYHq0eOx',
            '57dN52uHvrHOxijzpIgu3E',
            '1vCWHaC5f2uS3yhpwWbIA6',
        ]);

        self::assertSame(204, $response->getStatusCode());
    }

    public function testUnfollowArtist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(204);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->artists()->unfollow([
            '2CIMQHirSU0MQqyYHq0eOx',
            '57dN52uHvrHOxijzpIgu3E',
            '1vCWHaC5f2uS3yhpwWbIA6',
        ]);

        self::assertSame(204, $response->getStatusCode());
    }
}
