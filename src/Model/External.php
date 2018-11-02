<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

class External
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $value;

    /**
     * External constructor.
     *
     * @param string $type
     * @param string $value
     */
    public function __construct(string $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @param array $external
     *
     * @return \Kerox\Spotify\Model\External
     */
    public static function create(array $external): self
    {
        return new self(key($external), current($external));
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
