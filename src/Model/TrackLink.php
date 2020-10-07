<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Helper\BuilderTrait;
use Kerox\Spotify\Interfaces\TypeInterface;

class TrackLink implements ModelInterface, TypeInterface
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
    protected $type = self::TYPE_TRACK;

    /**
     * @var string
     */
    protected $uri;

    /**
     * TrackLink constructor.
     */
    public function __construct(array $externalUrls, string $href, string $id, string $uri)
    {
        $this->externalUrls = $externalUrls;
        $this->href = $href;
        $this->id = $id;
        $this->uri = $uri;
    }

    /**
     * @return \Kerox\Spotify\Model\TrackLink
     */
    public static function build(array $trackLink): self
    {
        $externalUrls = self::buildExternal($album['external_urls'] ?? []);

        $href = $trackLink['href'];
        $id = $trackLink['id'];
        $uri = $trackLink['uri'];

        return new self($externalUrls, $href, $id, $uri);
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

    public function getType(): string
    {
        return $this->type;
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}
