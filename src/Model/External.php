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
     */
    public function __construct(string $type, ?string $value = null)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @return \Kerox\Spotify\Model\External
     */
    public static function build(array $external): self
    {
        [$key, $value] = $external;

        return new self($key, $value);
    }

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
