<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Album;

class AlbumsResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Album[]
     */
    protected $albums = [];

    /**
     * @return array
     */
    public function getAlbums(): array
    {
        return $this->albums;
    }

    /**
     * @param int $albumNumber
     *
     * @return null|\Kerox\Spotify\Model\Album
     */
    public function getAlbum(int $albumNumber): ?Album
    {
        return $this->albums[$albumNumber] ?? null;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return \count($this->albums);
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        foreach ($content['albums'] as $album) {
            $this->albums[] = Album::build($album);
        }
    }
}
