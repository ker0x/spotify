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

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return \Kerox\Spotify\Model\Paging
     */
    public function getPlaylists(): Paging
    {
        return $this->playlists;
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        $this->message = $content['message'];
        $this->playlists = Paging::create($content['playlists']);
    }
}
