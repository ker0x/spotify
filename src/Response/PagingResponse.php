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

    public function getPaging(): Paging
    {
        return $this->paging;
    }

    protected function parseResponse(array $content): void
    {
        $this->paging = Paging::build($content);
    }
}
