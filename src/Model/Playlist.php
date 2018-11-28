<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use JsonSerializable;
use Kerox\Spotify\Interfaces\TypeInterface;

class Playlist implements TypeInterface, JsonSerializable
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $public;

    /**
     * @var bool
     */
    protected $collaborative;

    /**
     * @var null|string
     */
    protected $description;

    /**
     * @var array
     */
    protected $externalUrls;

    /**
     * @var \Kerox\Spotify\Model\Followers
     */
    protected $followers;

    /**
     * @var string
     */
    protected $href;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $images;

    /**
     * @var \Kerox\Spotify\Model\User
     */
    protected $owner;

    /**
     * @var null|string
     */
    protected $primaryColor;

    /**
     * @var string
     */
    protected $snapshotId;

    /**
     * @var array
     */
    protected $tracks;

    /**
     * @var string
     */
    protected $type = self::TYPE_PLAYLIST;

    /**
     * @var string
     */
    protected $uri;

    /**
     * Playlist constructor.
     *
     * @param bool                           $collaborative
     * @param string                         $description
     * @param array                          $externalUrls
     * @param \Kerox\Spotify\Model\Followers $followers
     * @param string                         $href
     * @param string                         $id
     * @param array                          $images
     * @param string                         $name
     * @param \Kerox\Spotify\Model\User      $owner
     * @param bool                           $public
     * @param string                         $snapshotId
     * @param array                          $tracks
     * @param string                         $uri
     */
    public function __construct(
        string $name,
        bool $public,
        bool $collaborative,
        ?string $description = null,
        array $externalUrls = [],
        ?Followers $followers = null,
        ?string $href = null,
        ?string $id = null,
        array $images = [],
        ?User $owner = null,
        ?string $primaryColor = null,
        ?string $snapshotId = null,
        array $tracks = [],
        ?string $uri = null
    ) {
        $this->name = $name;
        $this->public = $public;
        $this->collaborative = $collaborative;
        $this->description = $description;
        $this->externalUrls = $externalUrls;
        $this->followers = $followers;
        $this->href = $href;
        $this->id = $id;
        $this->images = $images;
        $this->owner = $owner;
        $this->primaryColor = $primaryColor;
        $this->snapshotId = $snapshotId;
        $this->tracks = $tracks;
        $this->uri = $uri;
    }

    /**
     * @param string      $name
     * @param bool        $public
     * @param bool        $collaborative
     * @param string|null $description
     *
     * @return \Kerox\Spotify\Model\Playlist
     */
    public static function create(
        string $name,
        bool $public = false,
        bool $collaborative = false,
        string $description = null
    ): self {
        return new self($name, $public, $collaborative, $description);
    }

    /**
     * @param array $playlist
     *
     * @return \Kerox\Spotify\Model\Playlist
     */
    public static function build(array $playlist): self
    {
        $collaborative = $playlist['collaborative'] ?? false;
        $description = $playlist['description'] ?? null;

        $externalUrls = [];
        foreach ($playlist['external_urls'] as $type => $url) {
            $externalUrls[] = External::build($type, $url);
        }

        $followers = null;
        if (isset($playlist['followers'])) {
            $followers = Followers::build($playlist['followers']);
        }

        $href = $playlist['href'];
        $id = $playlist['id'];

        $images = [];
        if (isset($playlist['images'])) {
            foreach ($playlist['images'] as $image) {
                $images[] = Image::build($image);
            }
        }

        $name = $playlist['name'];

        $owner = User::build($playlist['owner']);

        $primaryColor = $playlist['primary_color'] ?? null;
        $public = $playlist['public'] ?? false;
        $snapshotId = $playlist['snapshot_id'];
        $tracks = $playlist['tracks'] ?? [];
        $uri = $playlist['uri'];

        return new self(
            $name,
            $public,
            $collaborative,
            $description,
            $externalUrls,
            $followers,
            $href,
            $id,
            $images,
            $owner,
            $primaryColor,
            $snapshotId,
            $tracks,
            $uri
        );
    }

    /**
     * @return bool
     */
    public function isCollaborative(): bool
    {
        return $this->collaborative;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getExternalUrls(): array
    {
        return $this->externalUrls;
    }

    /**
     * @return \Kerox\Spotify\Model\Followers
     */
    public function getFollowers(): Followers
    {
        return $this->followers;
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
     * @return array
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
     * @return \Kerox\Spotify\Model\User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @return null|string
     */
    public function getPrimaryColor(): ?string
    {
        return $this->primaryColor;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->public;
    }

    /**
     * @return string
     */
    public function getSnapshotId(): string
    {
        return $this->snapshotId;
    }

    /**
     * @return null|string
     */
    public function getLinkToTracks(): ?string
    {
        return $this->tracks['href'] ?? null;
    }

    /**
     * @return int
     */
    public function getTotalTracks(): int
    {
        return $this->tracks['total'] ?? 0;
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
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'name' => $this->name,
            'public' => $this->public,
            'collaborative' => $this->collaborative,
            'description' => $this->description,
        ];

        return array_filter($array);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
