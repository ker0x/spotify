<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

class Image
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
     *
     * @param string   $url
     * @param int|null $height
     * @param int|null $width
     */
    public function __construct(string $url, ?int $height = null, ?int $width = null)
    {
        $this->url = $url;
        $this->height = $height;
        $this->width = $width;
    }

    /**
     * @param array $image
     *
     * @return \Kerox\Spotify\Model\Image
     */
    public static function create(array $image): self
    {
        $url = $image['url'];
        $height = $image['height'] ?? null;
        $width = $image['width'] ?? null;

        return new self($url, $height, $width);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }
}
