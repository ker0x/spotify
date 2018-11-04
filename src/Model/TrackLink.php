<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

class TrackLink
{
    public const TYPE = 'track';

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
    protected $type = self::TYPE;

    /**
     * @var string
     */
    protected $uri;

    /**
     * TrackLink constructor.
     *
     * @param array  $externalUrls
     * @param string $href
     * @param string $id
     * @param string $uri
     */
    public function __construct(array $externalUrls, string $href, string $id, string $uri)
    {
        $this->externalUrls = $externalUrls;
        $this->href = $href;
        $this->id = $id;
        $this->uri = $uri;
    }

    /**
     * @param array $trackLink
     *
     * @return \Kerox\Spotify\Model\TrackLink
     */
    public static function create(array $trackLink): self
    {
        $externalUrls = [];
        foreach ($trackLink['external_urls'] as $externalUrl) {
            $externalUrls[] = External::create($externalUrl);
        }

        $href = $trackLink['href'];
        $id = $trackLink['id'];
        $uri = $trackLink['uri'];

        return new self($externalUrls, $href, $id, $uri);
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