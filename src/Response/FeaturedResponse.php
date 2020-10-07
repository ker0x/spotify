<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Paging;

class FeaturedResponse extends AbstractResponse
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var \Kerox\Spotify\Model\Paging
     */
    protected $playlists;

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getPlaylists(): Paging
    {
        return $this->playlists;
    }

    protected function parseResponse(array $content): void
    {
        $this->message = $content['message'];
        $this->playlists = Paging::build($content['playlists']);
    }
}
