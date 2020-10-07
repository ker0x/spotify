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

    public function getArtists(): Paging
    {
        return $this->artists;
    }

    protected function parseResponse(array $content): void
    {
        $this->artists = Paging::build($content['artists']);
    }
}
