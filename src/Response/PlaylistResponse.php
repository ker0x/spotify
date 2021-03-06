<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Playlist;

class PlaylistResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Playlist
     */
    protected $playlist;

    public function getPlaylist(): Playlist
    {
        return $this->playlist;
    }

    protected function parseResponse(array $content): void
    {
        $this->playlist = Playlist::build($content);
    }
}
