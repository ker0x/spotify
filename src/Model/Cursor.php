<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Interfaces\ModelInterface;

class Cursor implements ModelInterface
{
    /**
     * @var string
     */
    protected $after;

    /**
     * Cursor constructor.
     */
    public function __construct(string $after)
    {
        $this->after = $after;
    }

    /**
     * @return \Kerox\Spotify\Model\Cursor
     */
    public static function build(array $cursor): self
    {
        return new self($cursor['after']);
    }

    public function getAfter(): string
    {
        return $this->after;
    }
}
