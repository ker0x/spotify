<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Paging;

class PlaylistsResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Paging
     */
    protected $playlists;

    public function getPlaylists(): Paging
    {
        return $this->playlists;
    }

    protected function parseResponse(array $content): void
    {
        $this->playlists = Paging::build($content['playlists']);
    }
}
