<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Artist;

class ArtistsResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Artist[]
     */
    protected $artists = [];

    /**
     * @return \Kerox\Spotify\Model\Artist[]
     */
    public function getArtists(): array
    {
        return $this->artists;
    }

    /**
     * @param int $artistNumber
     *
     * @return \Kerox\Spotify\Model\Artist|null
     */
    public function getArtist(int $artistNumber): ?Artist
    {
        return $this->artists[$artistNumber] ?? null;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return \count($this->artists);
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        foreach ($content['artists'] as $artist) {
            $this->artists[] = Artist::build($artist);
        }
    }
}
