<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Kerox\Spotify\Model\Category;

class CategoryResponse extends AbstractResponse
{
    /**
     * @var \Kerox\Spotify\Model\Category
     */
    protected $category;

    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        $this->category = Category::build($content);
    }
}
