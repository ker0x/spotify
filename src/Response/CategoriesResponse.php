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

    public function getCategories(): Paging
    {
        return $this->categories;
    }

    protected function parseResponse(array $content): void
    {
        $this->categories = Paging::build($content['categories']);
    }
}
