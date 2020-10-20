<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Album;

class AlbumResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Album
     */
    protected $album;

    public function getAlbum(): Album
    {
        return $this->album;
    }

    protected function parseResponse(array $content): void
    {
        $this->album = Album::build($content);
    }
}
