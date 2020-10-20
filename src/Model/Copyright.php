<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Interfaces\ModelInterface;

class Copyright implements ModelInterface
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $type;

    /**
     * Copyright constructor.
     */
    public function __construct(string $text, string $type)
    {
        $this->text = $text;
        $this->type = $type;
    }

    /**
     * @return \Kerox\Spotify\Model\Copyright
     */
    public static function build(array $copyright): self
    {
        return new self($copyright['text'], $copyright['type']);
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
