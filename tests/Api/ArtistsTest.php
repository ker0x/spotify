<?php

namespace Tests\Kerox\Spotify\TestCase\Api;

use Kerox\Spotify\Factory\QueryFactory;
use Kerox\Spotify\Factory\QueryFactoryInterface;
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

    protected function setUp()
    {
        $this->oauthToken = 'BQCpTK7nCpmijQURqGm-hBvOgS4T--ql1zfbiBVYwbzFb4z06fP8pFvLoiDSjSNawQEfRahU3pCJOQJIyhvi1JcmQtLJ_Oh-p3vKWhEfesG-UcIF_tPBjGRSn1Xu1w0QIbrvN9RnSm2-EI_NeNEOBxBHTlviYhq128bjG4obEeemHMIyAE2dJPIwumC-XPqfjXwkUGOVyfu5BJqERSVcT65m-g0xu9T52Q1RpJfvm5J0nGZw5Z647IEucZjqavtWycL2YnXLd02tSt9E0YY';
    }

    protected function tearDown()
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
        $response = $spotify->artists()->getArtist('0TnOYISbd1XYRBk9myaseg');

        $artist = $response->getArtist();

        $this->assertContainsOnlyInstancesOf(External::class, $artist->getExternalUrls());
        $this->assertInstanceOf(Followers::class, $artist->getFollowers());
        $this->assertNull($artist->getFollowers()->getHref());
        $this->assertSame(6406754, $artist->getFollowers()->getTotal());
        $this->assertSame(['dance pop', 'latin', 'pop', 'pop rap'], $artist->getGenres());
        $this->assertSame('https://api.spotify.com/v1/artists/0TnOYISbd1XYRBk9myaseg', $artist->getHref());
        $this->assertSame('0TnOYISbd1XYRBk9myaseg', $artist->getId());
        $this->assertContainsOnlyInstancesOf(Image::class, $artist->getImages());
        $this->assertSame('Pitbull', $artist->getName());
        $this->assertSame(82, $artist->getPopularity());
        $this->assertSame('artist', $artist->getType());
        $this->assertSame('spotify:artist:0TnOYISbd1XYRBk9myaseg', $artist->getUri());
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

        (new QueryFactory())
            ->setIncludeGroups(QueryFactory::INCLUDE_GROUPS_SINGLE, QueryFactory::INCLUDE_GROUPS_APPEARS_ON)
            ->setMarket('FR')
            ->setLimit(10)
            ->setOffset(5)

        $response = $spotify->artists()->getAlbums('0TnOYISbd1XYRBk9myaseg', (new QueryFactory())
            ->setIncludeGroups(QueryFactory::INCLUDE_GROUPS_SINGLE, QueryFactory::INCLUDE_GROUPS_APPEARS_ON)
            ->setMarket('FR')
            ->setLimit(10)
            ->setOffset(5)
        );

        $paging = $response->getPaging();

        $this->assertSame('https://api.spotify.com/v1/artists/0TnOYISbd1XYRBk9myaseg/albums?offset=5&limit=10&include_groups=single,appears_on&market=FR',
            $paging->getHref());
        $this->assertContainsOnlyInstancesOf(Album::class, $paging->getItems());
        $this->assertInstanceOf(Album::class, $paging->getItem(1));
        $this->assertSame(10, $paging->getLimit());
        $this->assertSame('https://api.spotify.com/v1/artists/0TnOYISbd1XYRBk9myaseg/albums?offset=15&limit=10&include_groups=single,appears_on&market=FR',
            $paging->getNext());
        $this->assertSame(5, $paging->getOffset());
        $this->assertSame('https://api.spotify.com/v1/artists/0TnOYISbd1XYRBk9myaseg/albums?offset=0&limit=10&include_groups=single,appears_on&market=FR',
            $paging->getPrevious());
        $this->assertSame(487, $paging->getTotal());
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
        $response = $spotify->artists()->getTopTracks('0TnOYISbd1XYRBk9myaseg', [
            QueryFactoryInterface::PARAMETER_MARKET => 'FR',
        ]);

        $this->assertContainsOnlyInstancesOf(Track::class, $response->getTracks());
        $this->assertInstanceOf(Track::class, $response->getTrack(1));
        $this->assertSame(10, $response->getTotal());
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
        $response = $spotify->artists()->getRelatedArtists('0TnOYISbd1XYRBk9myaseg');

        $this->assertContainsOnlyInstancesOf(Artist::class, $response->getArtists());
        $this->assertInstanceOf(Artist::class, $response->getArtist(1));
        $this->assertSame(20, $response->getTotal());
    }

    public function testGetArtists(): void
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
        $response = $spotify->artists()->getArtists((new QueryFactory())->setIds([
            '2CIMQHirSU0MQqyYHq0eOx',
            '57dN52uHvrHOxijzpIgu3E',
        ]));

        $this->assertContainsOnlyInstancesOf(Artist::class, $response->getArtists());
        $this->assertInstanceOf(Artist::class, $response->getArtist(1));
        $this->assertSame(2, $response->getTotal());
    }

    public function testFollowArtist(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(204);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->artists()->([
            '2CIMQHirSU0MQqyYHq0eOx',
            '57dN52uHvrHOxijzpIgu3E',
            '1vCWHaC5f2uS3yhpwWbIA6',
        ]);

        $this->assertSame(204, $response->getStatusCode());
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

        $this->assertSame(204, $response->getStatusCode());
    }
}