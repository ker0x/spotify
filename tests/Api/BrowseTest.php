<?php

declare(strict_types=1);

namespace Tests\Kerox\Spotify\TestCase\Api;

use Kerox\Spotify\Interfaces\QueryFactoryInterface;
use Kerox\Spotify\Model\Category;
use Kerox\Spotify\Model\Image;
use Kerox\Spotify\Model\Paging;
use Kerox\Spotify\Model\Seed;
use Kerox\Spotify\Model\Track;
use Kerox\Spotify\Response\CategoriesResponse;
use Kerox\Spotify\Response\CategoryResponse;
use Kerox\Spotify\Response\FeaturedResponse;
use Kerox\Spotify\Response\PlaylistsResponse;
use Kerox\Spotify\Response\RecommendationsResponse;
use Kerox\Spotify\Response\ReleasesResponse;
use Kerox\Spotify\Spotify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;

class BrowseTest extends TestCase
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

    public function testGetCategory(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Browse/category.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(CategoryResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->browse()->category('dinner', [
            QueryFactoryInterface::PARAMETER_COUNTRY => 'FR',
            QueryFactoryInterface::PARAMETER_LOCALE => 'fr_FR',
        ]);

        $category = $response->getCategory();

        $this->assertSame('https://api.spotify.com/v1/browse/categories/dinner', $category->getHref());
        $this->assertContainsOnlyInstancesOf(Image::class, $category->getIcons());
        $this->assertSame('dinner', $category->getId());
        $this->assertSame('Dîner', $category->getName());
    }

    public function testGetCategories(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Browse/categories.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(CategoriesResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->browse()->categories([
            QueryFactoryInterface::PARAMETER_COUNTRY => 'FR',
            QueryFactoryInterface::PARAMETER_LOCALE => 'fr_FR',
            QueryFactoryInterface::PARAMETER_LIMIT => 10,
            QueryFactoryInterface::PARAMETER_OFFSET => 5,
        ]);

        $categories = $response->getCategories();

        $this->assertContainsOnlyInstancesOf(Category::class, $categories->getItems());
        $this->assertInstanceOf(Category::class, $categories->getItem(1));
        $this->assertSame(10, $categories->getLimit());
        $this->assertSame(5, $categories->getOffset());
        $this->assertSame(37, $categories->getTotal());
        $this->assertSame(
            'https://api.spotify.com/v1/browse/categories?country=FR&locale=fr_fr&offset=5&limit=10',
            $categories->getHref()
        );
        $this->assertSame(
            'https://api.spotify.com/v1/browse/categories?country=FR&locale=fr_fr&offset=15&limit=10',
            $categories->getNext()
        );
        $this->assertSame(
            'https://api.spotify.com/v1/browse/categories?country=FR&locale=fr_fr&offset=0&limit=10',
            $categories->getPrevious()
        );
    }

    public function testGetFeatured(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Browse/featured-playlists.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(FeaturedResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->browse()->featured([
            QueryFactoryInterface::PARAMETER_COUNTRY => 'FR',
            QueryFactoryInterface::PARAMETER_LOCALE => 'fr_FR',
            QueryFactoryInterface::PARAMETER_TIMESTAMP => '2018-11-27T00:00:00',
            QueryFactoryInterface::PARAMETER_LIMIT => 10,
            QueryFactoryInterface::PARAMETER_OFFSET => 5,
        ]);

        $this->assertSame('A demain !', $response->getMessage());
        $this->assertInstanceOf(Paging::class, $response->getPlaylists());
    }

    public function testGetNewRelease(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Browse/new-releases.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(ReleasesResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->browse()->releases([
            QueryFactoryInterface::PARAMETER_COUNTRY => 'FR',
            QueryFactoryInterface::PARAMETER_LIMIT => 10,
            QueryFactoryInterface::PARAMETER_OFFSET => 5,
        ]);

        $this->assertInstanceOf(Paging::class, $response->getAlbums());
    }

    public function testGetPlaylists(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Browse/playlists.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(PlaylistsResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->browse()->playlists('dinner', [
            QueryFactoryInterface::PARAMETER_COUNTRY => 'FR',
            QueryFactoryInterface::PARAMETER_LIMIT => 10,
            QueryFactoryInterface::PARAMETER_OFFSET => 5,
        ]);

        $this->assertInstanceOf(Paging::class, $response->getPlaylists());
    }

    public function testGetRecommendations(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Browse/recommendations.json');

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createMock(RecommendationsResponse::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->willReturn(['content-type' => 'json']);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($response);

        $spotify = new Spotify($this->oauthToken, $client);
        $response = $spotify->browse()->recommendations([
            QueryFactoryInterface::PARAMETER_LIMIT => 10,
            QueryFactoryInterface::PARAMETER_MARKET => 'FR',
            QueryFactoryInterface::PARAMETER_SEED_ARTISTS => [
                '4NHQUGzhtTLFvgF5SZesLK',
            ],
            QueryFactoryInterface::PARAMETER_SEED_GENRES => [
                'rock',
                'metal',
            ],
            QueryFactoryInterface::PARAMETER_SEED_TRACKS => [
                '0c6xIDDpzE81m2q797ordA',
            ],
        ]);

        $recommendations = $response->getRecommendations();

        $this->assertContainsOnlyInstancesOf(Track::class, $recommendations->getTracks());
        $this->assertContainsOnlyInstancesOf(Seed::class, $recommendations->getSeeds());
        $this->assertSame(250, $recommendations->getSeeds()[0]->getInitialPoolSize());
        $this->assertSame(250, $recommendations->getSeeds()[0]->getAfterFilteringSize());
        $this->assertSame(247, $recommendations->getSeeds()[0]->getAfterRelinkingSize());
        $this->assertSame('4NHQUGzhtTLFvgF5SZesLK', $recommendations->getSeeds()[0]->getId());
        $this->assertSame('ARTIST', $recommendations->getSeeds()[0]->getType());
        $this->assertSame('https://api.spotify.com/v1/artists/4NHQUGzhtTLFvgF5SZesLK', $recommendations->getSeeds()[0]->getHref());
    }
}
