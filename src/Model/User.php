<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Interfaces\ModelInterface;

class User implements ModelInterface
{
    /**
     * @var string|null
     */
    protected $birthDate;

    /**
     * @var string|null
     */
    protected $country;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var string|null
     */
    protected $email;

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
     * @var \Kerox\Spotify\Model\Image[]
     */
    protected $images;

    /**
     * @var string|null
     */
    protected $product;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $uri;

    /**
     * User constructor.
     *
     * @param string                         $displayName
     * @param array                          $externalUrls
     * @param \Kerox\Spotify\Model\Followers $followers
     * @param string                         $href
     * @param string                         $id
     * @param array                          $images
     * @param string                         $type
     * @param string                         $uri
     * @param string|null                    $birthDate
     * @param string|null                    $country
     * @param string|null                    $email
     * @param string|null                    $product
     */
    public function __construct(
        array $externalUrls,
        string $href,
        string $id,
        array $images,
        string $type,
        string $uri,
        ?string $displayName = null,
        ?Followers $followers = null,
        ?string $birthDate = null,
        ?string $country = null,
        ?string $email = null,
        ?string $product = null
    ) {
        $this->externalUrls = $externalUrls;
        $this->href = $href;
        $this->id = $id;
        $this->images = $images;
        $this->type = $type;
        $this->uri = $uri;
        $this->displayName = $displayName;
        $this->followers = $followers;
        $this->birthDate = $birthDate;
        $this->country = $country;
        $this->email = $email;
        $this->product = $product;
    }

    /**
     * @param array $user
     *
     * @return \Kerox\Spotify\Model\User
     */
    public static function build(array $user): self
    {
        $displayName = $user['display_name'] ?? null;

        $externalUrls = [];
        foreach ($user['external_urls'] as $type => $url) {
            $externalUrls[] = External::build([$type, $url]);
        }

        $followers = null;
        if (isset($user['followers'])) {
            $followers = Followers::build($user['followers']);
        }

        $href = $user['href'];
        $id = $user['id'];

        $images = [];
        if (isset($user['images'])) {
            foreach ($user['images'] as $image) {
                $images[] = Image::build($image);
            }
        }

        $type = $user['type'];
        $uri = $user['uri'];
        $birthDate = $user['birthdate'] ?? null;
        $country = $user['country'] ?? null;
        $email = $user['email'] ?? null;
        $product = $user['product'] ?? null;

        return new self(
            $externalUrls,
            $href,
            $id,
            $images,
            $type,
            $uri,
            $displayName,
            $followers,
            $birthDate,
            $country,
            $email,
            $product
        );
    }

    /**
     * @return string|null
     */
    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
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
     * @return mixed
     */
    public function getId()
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
     * @return string|null
     */
    public function getProduct(): ?string
    {
        return $this->product;
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
