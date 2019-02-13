<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Model\ModelInterface;

class Cursor implements ModelInterface
{
    /**
     * @var string
     */
    protected $after;

    /**
     * Cursor constructor.
     *
     * @param string $after
     */
    public function __construct(string $after)
    {
        $this->after = $after;
    }

    /**
     * @param array $cursor
     *
     * @return \Kerox\Spotify\Model\Cursor
     */
    public static function build(array $cursor): self
    {
        return new self($cursor['after']);
    }

    /**
     * @return string
     */
    public function getAfter(): string
    {
        return $this->after;
    }
}
