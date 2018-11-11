<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

class User
{
    /**
     * @var null|string
     */
    protected $birthDate;

    /**
     * @var null|string
     */
    protected $country;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var null|string
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
     * @var array
     */
    protected $images;

    /**
     * @var null|string
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
     * @param null|string                    $birthDate
     * @param null|string                    $country
     * @param null|string                    $email
     * @param null|string                    $product
     */
    public function __construct(
        string $displayName,
        array $externalUrls,
        Followers $followers,
        string $href,
        string $id,
        array $images,
        string $type,
        string $uri,
        ?string $birthDate = null,
        ?string $country = null,
        ?string $email = null,
        ?string $product = null
    ) {
        $this->displayName = $displayName;
        $this->externalUrls = $externalUrls;
        $this->followers = $followers;
        $this->href = $href;
        $this->id = $id;
        $this->images = $images;
        $this->type = $type;
        $this->uri = $uri;
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
    public static function create(array $user): self
    {
        $displayName = $user['display_name'];

        $externalUrls = [];
        foreach ($user['external_urls'] as $type => $url) {
            $externalUrls[] = External::create($type, $url);;
        }

        $followers = Followers::create($user['followers']);

        $href = $user['href'];
        $id = $user['id'];

        $images = [];
        foreach ($user['images'] as $image) {
            $images[] = Image::create($image);
        }

        $type = $user['type'];
        $uri = $user['uri'];
        $birthDate = $user['birthdate'] ?? null;
        $country = $user['country'] ?? null;
        $email = $user['email'] ?? null;
        $product = $user['product'] ?? null;

        return new self(
            $displayName,
            $externalUrls,
            $followers,
            $href,
            $id,
            $images,
            $type,
            $uri,
            $birthDate,
            $country,
            $email,
            $product
        );
    }

    /**
     * @return null|string
     */
    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    /**
     * @return null|string
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
     * @return null|string
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
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return null|string
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
