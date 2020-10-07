<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

class Followers implements ModelInterface
{
    /**
     * @var string|null
     */
    protected $href;

    /**
     * @var int
     */
    protected $total;

    /**
     * Followers constructor.
     *
     * @param string $href
     */
    public function __construct(?string $href, int $total)
    {
        $this->href = $href;
        $this->total = $total;
    }

    /**
     * @return \Kerox\Spotify\Model\Followers
     */
    public static function build(array $followers): self
    {
        $href = $followers['href'];
        $total = $followers['total'];

        return new self($href, $total);
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
