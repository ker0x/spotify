<?php

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Image;

class ImagesResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Image[]
     */
    protected $images = [];

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param int $imageNumber
     *
     * @return \Kerox\Spotify\Model\Image
     */
    public function getImage(int $imageNumber): Image
    {
        return $this->images[++$imageNumber];
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return \count($this->images);
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        foreach ($content as $image) {
            $this->images[] = Image::build($image);
        }
    }
}
