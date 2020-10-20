<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Artist;

class ArtistResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Artist
     */
    protected $artist;

    public function getArtist(): Artist
    {
        return $this->artist;
    }

    protected function parseResponse(array $content): void
    {
        $this->artist = Artist::build($content);
    }
}
