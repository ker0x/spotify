<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Paging;

class SearchResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Paging|null
     */
    protected $albums;

    /**
     * @var \Kerox\Spotify\Model\Paging|null
     */
    protected $artists;

    /**
     * @var \Kerox\Spotify\Model\Paging|null
     */
    protected $playlists;

    /**
     * @var \Kerox\Spotify\Model\Paging|null
     */
    protected $tracks;

    protected function parseResponse(array $content): void
    {
        if (isset($content['albums'])) {
            $this->albums = Paging::build($content['albums']);
        }

        if (isset($content['artists'])) {
            $this->artists = Paging::build($content['artists']);
        }

        if (isset($content['playlists'])) {
            $this->playlists = Paging::build($content['playlists']);
        }

        if (isset($content['tracks'])) {
            $this->tracks = Paging::build($content['tracks']);
        }
    }

    public function getAlbums(): ?Paging
    {
        return $this->albums;
    }

    public function getArtists(): ?Paging
    {
        return $this->artists;
    }

    public function getPlaylists(): ?Paging
    {
        return $this->playlists;
    }

    public function getTracks(): ?Paging
    {
        return $this->tracks;
    }
}
