<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Paging;
use Kerox\Spotify\Model\Track;

class AlbumTracksResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Track[]
     */
    protected $tracks = [];

    /**
     * @var \Kerox\Spotify\Model\Paging
     */
    protected $paging;

    /**
     * @return \Kerox\Spotify\Model\Track[]
     */
    public function getTracks(): array
    {
        return $this->tracks;
    }

    /**
     * @param int $trackNumber
     *
     * @return \Kerox\Spotify\Model\Track|null
     */
    public function getTrack(int $trackNumber): ?Track
    {
        return $this->tracks[++$trackNumber] ?? null;
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        foreach ($content['items'] as $track) {
            $this->tracks[] = Track::create($track);
        }

        $this->paging = Paging::create($content);
    }
}
