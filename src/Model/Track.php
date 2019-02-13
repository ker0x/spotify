<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Interfaces\ModelInterface;
use Kerox\Spotify\Interfaces\TypeInterface;

class Track implements ModelInterface, TypeInterface
{
    /**
     * @var \Kerox\Spotify\Model\Album|null
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
     * @var \Kerox\Spotify\Model\External[]|null
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
     * @var \Kerox\Spotify\Model\TrackLink|null
     */
    protected $linkedFrom;

    /**
     * @var array
     */
    protected $restrictions;

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
     * @param array                               $artists
     * @param array                               $availableMarkets
     * @param int                                 $discNumber
     * @param int                                 $durationMs
     * @param bool                                $explicit
     * @param array                               $externalIds
     * @param array                               $externalUrls
     * @param string                              $href
     * @param string                              $id
     * @param bool                                $isPlayable
     * @param \Kerox\Spotify\Model\TrackLink|null $linkedFrom
     * @param array                               $restrictions
     * @param string                              $name
     * @param int                                 $trackNumber
     * @param string                              $type
     * @param string                              $uri
     * @param bool                                $isLocal
     * @param string                              $previewUrl
     * @param \Kerox\Spotify\Model\Album|null     $album
     * @param int|null                            $popularity
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
        ?TrackLink $linkedFrom,
        array $restrictions,
        string $name,
        int $trackNumber,
        string $type,
        string $uri,
        bool $isLocal,
        ?string $previewUrl = null,
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
        $this->linkedFrom = $linkedFrom;
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

        $availableMarkets = $track['available_markets'] ?? [];
        $discNumber = $track['disc_number'];
        $durationMs = $track['duration_ms'];
        $explicit = $track['explicit'];

        $externalIds = [];
        if (isset($track['external_ids'])) {
            foreach ($track['external_ids'] as $type => $url) {
                $externalIds[] = External::build([$type, $url]);
            }
        }

        $externalUrls = [];
        foreach ($track['external_urls'] as $type => $url) {
            $externalUrls[] = External::build([$type, $url]);
        }

        $href = $track['href'];
        $id = $track['id'];

        $isLocal = $track['is_local'] ?? false;
        $isPlayable = $track['is_playable'] ?? false;

        $linkedFrom = null;
        if (isset($track['linked_from'])) {
            $linkedFrom = TrackLink::build($track['linked_from']);
        }

        $restrictions = $track['restrictions'] ?? [];
        $name = $track['name'];
        $popularity = $track['popularity'] ?? null;
        $previewUrl = $track['preview_url'] ?? null;
        $trackNumber = $track['track_number'];
        $type = $track['type'];
        $uri = $track['uri'];

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
            $trackNumber,
            $type,
            $uri,
            $isLocal,
            $previewUrl,
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
     * @return \Kerox\Spotify\Model\TrackLink|null
     */
    public function getLinkedFrom(): ?TrackLink
    {
        return $this->linkedFrom;
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
     * @return string|null
     */
    public function getPreviewUrl(): ?string
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
