<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Helper\BuilderTrait;
use Kerox\Spotify\Interfaces\TypeInterface;

class Album implements ModelInterface, TypeInterface
{
    use BuilderTrait;

    /**
     * @var string|null
     */
    protected $albumGroup;

    /**
     * @var string|null
     */
    protected $albumType;

    /**
     * @var \Kerox\Spotify\Model\Artist[]
     */
    protected $artists;

    /**
     * @var array
     */
    protected $availableMarkets;

    /**
     * @var array
     */
    protected $copyrights;

    /**
     * @var array
     */
    protected $externalIds;

    /**
     * @var \Kerox\Spotify\Model\External[]
     */
    protected $externalUrls;

    /**
     * @var array
     */
    protected $genres;

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
     * @var string|null
     */
    protected $label;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int|null
     */
    protected $popularity;

    /**
     * @var string|null
     */
    protected $releaseDate;

    /**
     * @var string|null
     */
    protected $releaseDatePrecision;

    /**
     * @var string|null
     */
    protected $restrictions;

    /**
     * @var int|null
     */
    protected $totalTracks;

    /**
     * @var \Kerox\Spotify\Model\Paging|null
     */
    protected $tracks;

    /**
     * @var string
     */
    protected $type = self::TYPE_ALBUM;

    /**
     * @var string
     */
    protected $uri;

    /**
     * Album constructor.
     *
     * @param string                           $releaseDate
     * @param string                           $releaseDatePrecision
     * @param int                              $totalTracks
     * @param \Kerox\Spotify\Model\Paging|null $tracks
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
     * @return \Kerox\Spotify\Model\Album
     */
    public static function build(array $album): self
    {
        $artists = [];
        foreach ($album['artists'] as $artist) {
            $artists[] = Artist::build($artist);
        }

        $copyrights = [];
        if (isset($album['copyrights'])) {
            foreach ($album['copyrights'] as $copyright) {
                $copyrights[] = Copyright::build($copyright);
            }
        }

        $tracks = null;
        if (isset($album['tracks'])) {
            $tracks = Paging::build($album['tracks']);
        }

        $images = self::buildImages($album['images'] ?? []);
        $externalIds = self::buildExternal($album['external_ids'] ?? []);
        $externalUrls = self::buildExternal($album['external_urls'] ?? []);
        $availableMarkets = $album['available_markets'] ?? [];
        $albumGroup = $album['album_group'] ?? null;
        $albumType = $album['album_type'] ?? null;
        $genres = $album['genres'] ?? [];
        $href = $album['href'];
        $id = $album['id'];
        $label = $album['label'] ?? null;
        $name = $album['name'];
        $popularity = $album['popularity'] ?? null;
        $releaseDate = $album['release_date'] ?? null;
        $releaseDatePrecision = $album['release_date_precision'] ?? null;
        $totalTracks = $album['total_tracks'] ?? null;
        $restrictions = $album['restrictions'] ?? null;
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

    public function getHref(): string
    {
        return $this->href;
    }

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getPopularity(): ?int
    {
        return $this->popularity;
    }

    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    public function getReleaseDatePrecision(): ?string
    {
        return $this->releaseDatePrecision;
    }

    public function getTotalTracks(): ?int
    {
        return $this->totalTracks;
    }

    public function getRestrictions(): ?string
    {
        return $this->restrictions;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getAlbumGroup(): ?string
    {
        return $this->albumGroup;
    }

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

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @return \Kerox\Spotify\Model\Paging|null
     */
    public function getTracks(): ?Paging
    {
        return $this->tracks;
    }
}
