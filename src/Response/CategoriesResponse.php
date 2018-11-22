<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Paging;

class CategoriesResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Paging
     */
    protected $categories;

    /**
     * @return \Kerox\Spotify\Model\Paging
     */
    public function getCategories(): Paging
    {
        return $this->categories;
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        $this->categories = Paging::build($content['categories']);
    }
}
