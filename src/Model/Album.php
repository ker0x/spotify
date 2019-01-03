<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Interfaces\TypeInterface;

class Album implements TypeInterface
{
    /**
     * @var \Kerox\Spotify\Model\Artist[]
     */
    protected $artists;

    /**
     * @var array
     */
    protected $availableMarkets;

    /**
     * @var \Kerox\Spotify\Model\External[]
     */
    protected $externalUrls;

    /**
     * @var string
     */
    protected $href;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var \Kerox\Spotify\Model\Image[]
     */
    protected $images;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var null|int
     */
    protected $popularity;

    /**
     * @var null|string
     */
    protected $releaseDate;

    /**
     * @var null|string
     */
    protected $releaseDatePrecision;

    /**
     * @var null|int
     */
    protected $totalTracks;

    /**
     * @var null|string
     */
    protected $restrictions;

    /**
     * @var string
     */
    protected $type = self::TYPE_ALBUM;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var null|string
     */
    protected $albumGroup;

    /**
     * @var null|string
     */
    protected $albumType;

    /**
     * @var array
     */
    protected $copyrights;

    /**
     * @var array
     */
    protected $externalIds;

    /**
     * @var array
     */
    protected $genres;

    /**
     * @var null|string
     */
    protected $label;

    /**
     * @var null|\Kerox\Spotify\Model\Paging
     */
    protected $tracks;

    /**
     * Album constructor.
     *
     * @param array                            $artists
     * @param array                            $availableMarkets
     * @param array                            $externalUrls
     * @param string                           $href
     * @param string                           $id
     * @param array                            $images
     * @param string                           $name
     * @param string                           $releaseDate
     * @param string                           $releaseDatePrecision
     * @param int                              $totalTracks
     * @param null|string                      $restrictions
     * @param string                           $uri
     * @param null|\Kerox\Spotify\Model\Paging $tracks
     * @param null|string                      $albumType
     * @param null|string                      $albumGroup
     * @param array                            $copyrights
     * @param array                            $externalIds
     * @param array                            $genres
     * @param null|string                      $label
     * @param int|null                         $popularity
     */
    public function __construct(
        array $artists,
        array $availableMarkets,
        array $externalUrls,
        string $href,
        string $id,
        array $images,
        string $name,
        string $uri,
        ?string $releaseDate = null,
        ?string $releaseDatePrecision = null,
        ?int $totalTracks = null,
        ?string $restrictions = null,
        ?Paging $tracks = null,
        ?string $albumType = null,
        ?string $albumGroup = null,
        array $copyrights = [],
        array $externalIds = [],
        array $genres = [],
        ?string $label = null,
        ?int $popularity = null
    ) {
        $this->artists = $artists;
        $this->availableMarkets = $availableMarkets;
        $this->externalUrls = $externalUrls;
        $this->href = $href;
        $this->id = $id;
        $this->images = $images;
        $this->name = $name;
        $this->releaseDate = $releaseDate;
        $this->releaseDatePrecision = $releaseDatePrecision;
        $this->totalTracks = $totalTracks;
        $this->restrictions = $restrictions;
        $this->uri = $uri;
        $this->tracks = $tracks;
        $this->albumType = $albumType;
        $this->albumGroup = $albumGroup;
        $this->copyrights = $copyrights;
        $this->externalIds = $externalIds;
        $this->genres = $genres;
        $this->label = $label;
        $this->popularity = $popularity;
    }

    /**
     * @param array $album
     *
     * @return \Kerox\Spotify\Model\Album
     */
    public static function build(array $album): self
    {
        $albumGroup = $album['album_group'] ?? null;
        $albumType = $album['album_type'] ?? null;

        $artists = [];
        foreach ($album['artists'] as $artist) {
            $artists[] = Artist::build($artist);
        }

        $availableMarkets = $album['available_markets'] ?? [];

        $copyrights = [];
        if (isset($album['copyrights'])) {
            foreach ($album['copyrights'] as $copyright) {
                $copyrights[] = Copyright::build($copyright);
            }
        }

        $externalIds = [];
        if (isset($album['external_ids'])) {
            foreach ($album['external_ids'] as $type => $id) {
                $externalIds[] = External::build($type, $id);
            }
        }

        $externalUrls = [];
        foreach ($album['external_urls'] as $type => $url) {
            $externalUrls[] = External::build($type, $url);
        }

        $genres = $album['genres'] ?? [];
        $href = $album['href'];
        $id = $album['id'];

        $images = [];
        foreach ($album['images'] as $image) {
            $images[] = Image::build($image);
        }

        $label = $album['label'] ?? null;
        $name = $album['name'];
        $popularity = $album['popularity'] ?? null;
        $releaseDate = $album['release_date'] ?? null;
        $releaseDatePrecision = $album['release_date_precision'] ?? null;
        $totalTracks = $album['total_tracks'] ?? null;
        $restrictions = $album['restrictions'] ?? null;

        $tracks = null;
        if (isset($album['tracks'])) {
            $tracks = Paging::build($album['tracks']);
        }

        $uri = $album['uri'];

        return new self(
            $artists,
            $availableMarkets,
            $externalUrls,
            $href,
            $id,
            $images,
            $name,
            $uri,
            $releaseDate,
            $releaseDatePrecision,
            $totalTracks,
            $restrictions,
            $tracks,
            $albumType,
            $albumGroup,
            $copyrights,
            $externalIds,
            $genres,
            $label,
            $popularity
        );
    }

    /**
     * @return \Kerox\Spotify\Model\Artist[]
     */
    public function getArtists(): array
    {
        return $this->artists;
    }

    /**
     * @return array
     */
    public function getAvailableMarkets(): array
    {
        return $this->availableMarkets;
    }

    /**
     * @return \Kerox\Spotify\Model\External[]
     */
    public function getExternalUrls(): array
    {
        return $this->externalUrls;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return \Kerox\Spotify\Model\Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getPopularity(): ?int
    {
        return $this->popularity;
    }

    /**
     * @return null|string
     */
    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    /**
     * @return null|string
     */
    public function getReleaseDatePrecision(): ?string
    {
        return $this->releaseDatePrecision;
    }

    /**
     * @return null|int
     */
    public function getTotalTracks(): ?int
    {
        return $this->totalTracks;
    }

    /**
     * @return null|string
     */
    public function getRestrictions(): ?string
    {
        return $this->restrictions;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return null|string
     */
    public function getAlbumGroup(): ?string
    {
        return $this->albumGroup;
    }

    /**
     * @return null|string
     */
    public function getAlbumType(): ?string
    {
        return $this->albumType;
    }

    /**
     * @return \Kerox\Spotify\Model\Copyright[]
     */
    public function getCopyrights(): array
    {
        return $this->copyrights;
    }

    /**
     * @return \Kerox\Spotify\Model\External[]
     */
    public function getExternalIds(): array
    {
        return $this->externalIds;
    }

    /**
     * @return array
     */
    public function getGenres(): array
    {
        return $this->genres;
    }

    /**
     * @return null|string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @return null|\Kerox\Spotify\Model\Paging
     */
    public function getTracks(): ?Paging
    {
        return $this->tracks;
    }
}
