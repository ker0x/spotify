<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Interfaces\ModelInterface;

class External implements ModelInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string|null
     */
    protected $value;

    /**
     * External constructor.
     *
     * @param string      $type
     * @param string|null $value
     */
    public function __construct(string $type, ?string $value = null)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @param array $external
     *
     * @return \Kerox\Spotify\Model\External
     */
    public static function build(array $external): self
    {
        [$key, $value] = $external;

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
