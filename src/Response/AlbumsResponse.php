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
     * @param int $index
     *
     * @return \Kerox\Spotify\Model\Album|null
     */
    public function getAlbum(int $index): ?Album
    {
        return $this->albums[$index] ?? null;
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
