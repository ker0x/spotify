<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Track;

class TracksResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Track[]
     */
    protected $tracks = [];

    /**
     * @return \Kerox\Spotify\Model\Track[]
     */
    public function getTracks(): array
    {
        return $this->tracks;
    }

    public function getTrack(int $index): ?Track
    {
        return $this->tracks[$index] ?? null;
    }

    public function getTotal(): int
    {
        return \count($this->tracks);
    }

    protected function parseResponse(array $content): void
    {
        foreach ($content['tracks'] as $track) {
            $this->tracks[] = Track::build($track);
        }
    }
}
