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
     * @var null|string
     */
    protected $value;

    /**
     * External constructor.
     *
     * @param string      $type
     * @param null|string $value
     */
    public function __construct(string $type, ?string $value = null)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return \Kerox\Spotify\Model\External
     */
    public static function build(string $key, ?string $value = null): self
    {
        return new self($key, $value);
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
    public function getValue(): ?string
    {
        return $this->value;
    }
}
