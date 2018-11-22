<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

class Copyright
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
     *
     * @param string $text
     * @param string $type
     */
    public function __construct(string $text, string $type)
    {
        $this->text = $text;
        $this->type = $type;
    }

    /**
     * @param array $copyright
     *
     * @return \Kerox\Spotify\Model\Copyright
     */
    public static function build(array $copyright): self
    {
        return new self($copyright['text'], $copyright['type']);
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
