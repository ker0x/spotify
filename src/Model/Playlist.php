<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use JsonSerializable;
use Kerox\Spotify\Helper\BuilderTrait;
use Kerox\Spotify\Interfaces\TypeInterface;

class Playlist implements ModelInterface, TypeInterface, JsonSerializable
{
    use BuilderTrait;

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
     * @var string|null
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
     * @var string|null
     */
    protected $primaryColor;

    /**
     * @var string
     */
    protected $snapshotId;

    /**
     * @var \Kerox\Spotify\Model\Paging|null
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
     * @param string                         $description
     * @param \Kerox\Spotify\Model\Followers $followers
     * @param string                         $href
     * @param string                         $id
     * @param \Kerox\Spotify\Model\User      $owner
     * @param string                         $snapshotId
     * @param \Kerox\Spotify\Model\Paging    $tracks
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
        ?Paging $tracks = null,
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
     * @return \Kerox\Spotify\Model\Playlist
     */
    public static function build(array $playlist): self
    {
        $externalUrls = self::buildExternal($playlist['external_urls'] ?? []);
        $followers = self::buildFollowers($playlist['followers'] ?? null);
        $images = self::buildImages($playlist['images'] ?? []);
        $collaborative = $playlist['collaborative'] ?? false;
        $description = $playlist['description'] ?? null;
        $href = $playlist['href'];
        $id = $playlist['id'];
        $name = $playlist['name'];
        $owner = User::build($playlist['owner']);
        $primaryColor = $playlist['primary_color'] ?? null;
        $public = $playlist['public'] ?? false;
        $snapshotId = $playlist['snapshot_id'];
        $tracks = Paging::build($playlist['tracks']);
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

    public function isCollaborative(): bool
    {
        return $this->collaborative;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

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

    public function getHref(): string
    {
        return $this->href;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getImages(): array
    {
        return $this->images;
    }

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

    public function getPrimaryColor(): ?string
    {
        return $this->primaryColor;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function getSnapshotId(): string
    {
        return $this->snapshotId;
    }

    /**
     * @return \Kerox\Spotify\Model\Paging|null
     */
    public function getTracks(): ?Paging
    {
        return $this->tracks;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function toArray(): array
    {
        $array = [
            'name' => $this->name,
            'public' => $this->public,
            'collaborative' => $this->collaborative,
            'description' => $this->description,
        ];

        return $array;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
