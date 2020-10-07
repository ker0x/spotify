<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Helper\BuilderTrait;
use Kerox\Spotify\Interfaces\TypeInterface;

class Track implements ModelInterface, TypeInterface
{
    use BuilderTrait;

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
     * @param \Kerox\Spotify\Model\TrackLink|null $linkedFrom
     * @param string                              $previewUrl
     * @param \Kerox\Spotify\Model\Album|null     $album
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

        $externalIds = self::buildExternal($album['external_ids'] ?? []);
        $externalUrls = self::buildExternal($album['external_urls'] ?? []);

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

    public function getAvailableMarkets(): array
    {
        return $this->availableMarkets;
    }

    public function getDiscNumber(): int
    {
        return $this->discNumber;
    }

    public function getDurationMs(): int
    {
        return $this->durationMs;
    }

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

    public function getHref(): string
    {
        return $this->href;
    }

    public function getId(): string
    {
        return $this->id;
    }

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

    public function getRestrictions(): array
    {
        return $this->restrictions;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPopularity(): ?int
    {
        return $this->popularity;
    }

    public function getPreviewUrl(): ?string
    {
        return $this->previewUrl;
    }

    public function getTrackNumber(): int
    {
        return $this->trackNumber;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function isLocal(): bool
    {
        return $this->isLocal;
    }
}
