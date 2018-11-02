<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Track;

class TrackResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Track
     */
    protected $track;

    /**
     * @return \Kerox\Spotify\Model\Track
     */
    public function getTrack(): Track
    {
        return $this->track;
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        $this->track = Track::create($content);
    }
}
