<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Paging;

class PagingResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Paging
     */
    protected $paging;

    /**
     * @return \Kerox\Spotify\Model\Paging
     */
    public function getPaging(): Paging
    {
        return $this->paging;
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        $this->paging = Paging::build($content);
    }
}
