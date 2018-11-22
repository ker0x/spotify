<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Interfaces\TypeInterface;

class Track implements TypeInterface
{
    /**
     * @var null|\Kerox\Spotify\Model\Album
     */
    protected $album;

    /**
     * @var \Kerox\Spotify\Model\Artist[]
     */
    protected $artists;

    /**
     * @var array
     */
    protected $availableMarkets;

    /**
     * @var int
     */
    protected $discNumber;

    /**
     * @var int
     */
    protected $durationMs;

    /**
     * @var bool
     */
    protected $explicit;

    /**
     * @var null|\Kerox\Spotify\Model\External[]
     */
    protected $externalIds;

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
     * @var bool
     */
    protected $isPlayable;

    /**
     * @var \Kerox\Spotify\Model\TrackLink
     */
    protected $linkedForm;

    /**
     * @var array
     */
    protected $restrictions;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var null|int
     */
    protected $popularity;

    /**
     * @var string
     */
    protected $previewUrl;

    /**
     * @var int
     */
    protected $trackNumber;

    /**
     * @var string
     */
    protected $type = self::TYPE_TRACK;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var bool
     */
    protected $isLocal;

    /**
     * Track constructor.
     *
     * @param array                           $artists
     * @param array                           $availableMarkets
     * @param int                             $discNumber
     * @param int                             $durationMs
     * @param bool                            $explicit
     * @param array                           $externalIds
     * @param array                           $externalUrls
     * @param string                          $href
     * @param string                          $id
     * @param bool                            $isPlayable
     * @param \Kerox\Spotify\Model\TrackLink  $linkedForm
     * @param array                           $restrictions
     * @param string                          $name
     * @param string                          $previewUrl
     * @param int                             $trackNumber
     * @param string                          $type
     * @param string                          $uri
     * @param bool                            $isLocal
     * @param \Kerox\Spotify\Model\Album|null $album
     * @param int|null                        $popularity
     */
    public function __construct(
        array $artists,
        array $availableMarkets,
        int $discNumber,
        int $durationMs,
        bool $explicit,
        array $externalIds,
        array $externalUrls,
        string $href,
        string $id,
        bool $isPlayable,
        TrackLink $linkedForm,
        array $restrictions,
        string $name,
        string $previewUrl,
        int $trackNumber,
        string $type,
        string $uri,
        bool $isLocal,
        ?Album $album = null,
        ?int $popularity = null
    ) {
        $this->artists = $artists;
        $this->availableMarkets = $availableMarkets;
        $this->discNumber = $discNumber;
        $this->durationMs = $durationMs;
        $this->explicit = $explicit;
        $this->externalIds = $externalIds;
        $this->externalUrls = $externalUrls;
        $this->href = $href;
        $this->id = $id;
        $this->isPlayable = $isPlayable;
        $this->linkedForm = $linkedForm;
        $this->restrictions = $restrictions;
        $this->name = $name;
        $this->previewUrl = $previewUrl;
        $this->trackNumber = $trackNumber;
        $this->type = $type;
        $this->uri = $uri;
        $this->isLocal = $isLocal;
        $this->album = $album;
        $this->popularity = $popularity;
    }

    /**
     * @param array $track
     *
     * @return \Kerox\Spotify\Model\Track
     */
    public static function build(array $track): self
    {
        $album = null;
        if (isset($track['album'])) {
            $album = Album::build($track['album']);
        }

        $artists = [];
        foreach ($track['artists'] as $artist) {
            $artists[] = Artist::build($artist);
        }

        $availableMarkets = $track['available_markets'];
        $discNumber = $track['disc_number'];
        $durationMs = $track['duration_ms'];
        $explicit = $track['explicit'];

        $externalIds = [];
        if (isset($album['external_ids'])) {
            foreach ($album['external_ids'] as $type => $url) {
                $externalUrls[] = External::build($type, $url);;
            }
        }

        $externalUrls = [];
        foreach ($album['external_urls'] as $externalUrl) {
            $externalUrls[] = External::build($externalUrl);
        }

        $href = $track['href'];
        $id = $track['id'];

        $isPlayable = $track['is_playable'];
        $linkedFrom = TrackLink::build($track['linked_from']);

        $restrictions = $track['restrictions'];
        $name = $track['name'];
        $popularity = $track['popularity'] ?? null;
        $previewUrl = $track['preview_url'];
        $trackNumber = $track['track_number'];
        $type = $track['type'];
        $uri = $track['uri'];
        $isLocal = $track['is_local'];

        return new self(
            $artists,
            $availableMarkets,
            $discNumber,
            $durationMs,
            $explicit,
            $externalIds,
            $externalUrls,
            $href,
            $id,
            $isPlayable,
            $linkedFrom,
            $restrictions,
            $name,
            $previewUrl,
            $trackNumber,
            $type,
            $uri,
            $isLocal,
            $album,
            $popularity
        );
    }

    /**
     * @return \Kerox\Spotify\Model\Album|null
     */
    public function getAlbum(): ?Album
    {
        return $this->album;
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
     * @return int
     */
    public function getDiscNumber(): int
    {
        return $this->discNumber;
    }

    /**
     * @return int
     */
    public function getDurationMs(): int
    {
        return $this->durationMs;
    }

    /**
     * @return bool
     */
    public function isExplicit(): bool
    {
        return $this->explicit;
    }

    /**
     * @return \Kerox\Spotify\Model\External[]|null
     */
    public function getExternalIds(): ?array
    {
        return $this->externalIds;
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
     * @return bool
     */
    public function isPlayable(): bool
    {
        return $this->isPlayable;
    }

    /**
     * @return \Kerox\Spotify\Model\TrackLink
     */
    public function getLinkedForm(): TrackLink
    {
        return $this->linkedForm;
    }

    /**
     * @return array
     */
    public function getRestrictions(): array
    {
        return $this->restrictions;
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
     * @return string
     */
    public function getPreviewUrl(): string
    {
        return $this->previewUrl;
    }

    /**
     * @return int
     */
    public function getTrackNumber(): int
    {
        return $this->trackNumber;
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
     * @return bool
     */
    public function isLocal(): bool
    {
        return $this->isLocal;
    }
}
