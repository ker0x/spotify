<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Image;

class ImagesResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Image[]
     */
    protected $images = [];

    public function getImages(): array
    {
        return $this->images;
    }

    public function getImage(int $imageNumber): Image
    {
        return $this->images[$imageNumber];
    }

    public function getTotal(): int
    {
        return \count($this->images);
    }

    protected function parseResponse(array $content): void
    {
        foreach ($content as $image) {
            $this->images[] = Image::build($image);
        }
    }
}
