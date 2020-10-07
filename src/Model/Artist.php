<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Helper\BuilderTrait;
use Kerox\Spotify\Interfaces\TypeInterface;

class Artist implements ModelInterface, TypeInterface
{
    use BuilderTrait;

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
     * @param \Kerox\Spotify\Model\Followers|null $followers
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
     * @return \Kerox\Spotify\Model\Artist
     */
    public static function build(array $artist): self
    {
        $externalUrls = self::buildExternal($artist['external_urls'] ?? []);
        $followers = self::buildFollowers($artist['followers'] ?? null);
        $images = self::buildImages($artist['images'] ?? []);
        $genres = $artist['genres'] ?? [];
        $href = $artist['href'];
        $id = $artist['id'];
        $name = $artist['name'];
        $popularity = $artist['popularity'] ?? null;
        $uri = $artist['uri'];

        return new self($externalUrls, $href, $id, $name, $uri, $followers, $genres, $images, $popularity);
    }

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

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

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function getPopularity(): ?int
    {
        return $this->popularity;
    }
}
