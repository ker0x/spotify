<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Paging;

class UserFollowingResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Paging
     */
    protected $artists;

    /**
     * @return \Kerox\Spotify\Model\Paging
     */
    public function getArtists(): Paging
    {
        return $this->artists;
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        $this->artists = Paging::build($content['artists']);
    }
}
