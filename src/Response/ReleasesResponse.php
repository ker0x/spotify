<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Paging;

class ReleasesResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Paging
     */
    protected $albums;

    /**
     * @return \Kerox\Spotify\Model\Paging
     */
    public function getAlbums(): Paging
    {
        return $this->albums;
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        $this->albums = Paging::build($content['albums']);
    }
}
