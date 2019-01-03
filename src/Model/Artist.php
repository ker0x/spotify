<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Interfaces\ModelInterface;
use Kerox\Spotify\Interfaces\TypeInterface;

class Artist implements ModelInterface, TypeInterface
{
    /**
     * @var array
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
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type = self::TYPE_ARTIST;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var \Kerox\Spotify\Model\Followers|null
     */
    protected $followers;

    /**
     * @var array
     */
    protected $genres;

    /**
     * @var array
     */
    protected $images;

    /**
     * @var int|null
     */
    protected $popularity;

    /**
     * Artist constructor.
     *
     * @param array                               $externalUrls
     * @param string                              $href
     * @param string                              $id
     * @param string                              $name
     * @param string                              $uri
     * @param \Kerox\Spotify\Model\Followers|null $followers
     * @param array                               $genres
     * @param array                               $images
     * @param int|null                            $popularity
     */
    public function __construct(
        array $externalUrls,
        string $href,
        string $id,
        string $name,
        string $uri,
        ?Followers $followers = null,
        array $genres = [],
        array $images = [],
        ?int $popularity = null
    ) {
        $this->externalUrls = $externalUrls;
        $this->href = $href;
        $this->id = $id;
        $this->name = $name;
        $this->uri = $uri;
        $this->followers = $followers;
        $this->genres = $genres;
        $this->images = $images;
        $this->popularity = $popularity;
    }

    /**
     * @param array $artist
     *
     * @return \Kerox\Spotify\Model\Artist
     */
    public static function build(array $artist): self
    {
        $externalUrls = [];
        foreach ($artist['external_urls'] as $type => $url) {
            $externalUrls[] = External::build([$type, $url]);
        }

        $followers = null;
        if (isset($artist['followers'])) {
            $followers = Followers::build($artist['followers']);
        }

        $genres = $artist['genres'] ?? [];
        $href = $artist['href'];
        $id = $artist['id'];

        $images = [];
        if (isset($artist['images'])) {
            foreach ($artist['images'] as $image) {
                $images[] = Image::build($image);
            }
        }

        $name = $artist['name'];
        $popularity = $artist['popularity'] ?? null;
        $uri = $artist['uri'];

        return new self($externalUrls, $href, $id, $name, $uri, $followers, $genres, $images, $popularity);
    }

    /**
     * @return array
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * @return \Kerox\Spotify\Model\Followers|null
     */
    public function getFollowers(): ?Followers
    {
        return $this->followers;
    }

    /**
     * @return array
     */
    public function getGenres(): array
    {
        return $this->genres;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return int|null
     */
    public function getPopularity(): ?int
    {
        return $this->popularity;
    }
}
