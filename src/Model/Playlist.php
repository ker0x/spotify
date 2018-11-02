<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

class Playlist
{
    /**
     * @var bool
     */
    protected $collaborative;

    /**
     * @var string
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
     * @var string
     */
    protected $name;

    /**
     * @var \Kerox\Spotify\Model\User
     */
    protected $owner;

    /**
     * @var bool
     */
    protected $public;

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
    protected $type;
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
     * @param string                         $type
     * @param string                         $uri
     */
    public function __construct(
        bool $collaborative,
        string $description,
        array $externalUrls,
        Followers $followers,
        string $href,
        string $id,
        array $images,
        string $name,
        User $owner,
        bool $public,
        string $snapshotId,
        array $tracks,
        string $type,
        string $uri
    ) {
        $this->collaborative = $collaborative;
        $this->description = $description;
        $this->externalUrls = $externalUrls;
        $this->followers = $followers;
        $this->href = $href;
        $this->id = $id;
        $this->images = $images;
        $this->name = $name;
        $this->owner = $owner;
        $this->public = $public;
        $this->snapshotId = $snapshotId;
        $this->tracks = $tracks;
        $this->type = $type;
        $this->uri = $uri;
    }

    /**
     * @param array $playlist
     *
     * @return \Kerox\Spotify\Model\Playlist
     */
    public static function create(array $playlist): self
    {
        $collaborative = $playlist['collaborative'];
        $description = $playlist['description'];

        $externalUrls = [];
        foreach ($artist['external_urls'] as $externalUrl) {
            $externalUrls[] = External::create($externalUrl);
        }

        $followers = Followers::create($playlist['followers']);

        $href = $playlist['href'];
        $id = $playlist['id'];

        $images = [];
        if (isset($artist['images'])) {
            foreach ($artist['images'] as $image) {
                $images[] = Image::create($image);
            }
        }

        $name = $playlist['name'];

        $owner = User::create($playlist['owner']);

        $public = $playlist['public'];
        $snapshotId = $playlist['snapshot_id'];

        $tracks = [];
        foreach ($playlist['tracks'] as $track) {
            $tracks[] = Track::create($track);
        }

        $type = $playlist['type'];
        $uri = $playlist['uri'];

        return new self(
            $collaborative,
            $description,
            $externalUrls,
            $followers,
            $href,
            $id,
            $images,
            $name,
            $owner,
            $public,
            $snapshotId,
            $tracks,
            $type,
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
     * @return string
     */
    public function getDescription(): string
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
     * @return array
     */
    public function getTracks(): array
    {
        return $this->tracks;
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
}
