<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Paging;

class SearchResponse extends AbstractResponse
{
    /**
     * @var null|\Kerox\Spotify\Model\Paging
     */
    protected $albums;

    /**
     * @var null|\Kerox\Spotify\Model\Paging
     */
    protected $artists;

    /**
     * @var null|\Kerox\Spotify\Model\Paging
     */
    protected $playlists;

    /**
     * @var null|\Kerox\Spotify\Model\Paging
     */
    protected $tracks;

    /**
     * @param array $content
     */
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

    /**
     * @return \Kerox\Spotify\Model\Paging|null
     */
    public function getAlbums(): ?Paging
    {
        return $this->albums;
    }

    /**
     * @return \Kerox\Spotify\Model\Paging|null
     */
    public function getArtists(): ?Paging
    {
        return $this->artists;
    }

    /**
     * @return \Kerox\Spotify\Model\Paging|null
     */
    public function getPlaylists(): ?Paging
    {
        return $this->playlists;
    }

    /**
     * @return \Kerox\Spotify\Model\Paging|null
     */
    public function getTracks(): ?Paging
    {
        return $this->tracks;
    }
}
