<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Interfaces\ModelInterface;

class Image implements ModelInterface
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var int|null
     */
    protected $height;

    /**
     * @var int|null
     */
    protected $width;

    /**
     * Image constructor.
     */
    public function __construct(string $url, ?int $height = null, ?int $width = null)
    {
        $this->url = $url;
        $this->height = $height;
        $this->width = $width;
    }

    /**
     * @return \Kerox\Spotify\Model\Image
     */
    public static function build(array $image): self
    {
        $url = $image['url'];
        $height = $image['height'] ?? null;
        $width = $image['width'] ?? null;

        return new self($url, $height, $width);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }
}
