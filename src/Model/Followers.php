<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

class Followers
{
    /**
     * @var string
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
     * @param int    $total
     */
    public function __construct(?string $href, int $total)
    {
        $this->href = $href;
        $this->total = $total;
    }

    /**
     * @param array $followers
     *
     * @return \Kerox\Spotify\Model\Followers
     */
    public static function build(array $followers): self
    {
        $href = $followers['href'];
        $total = $followers['total'];

        return new self($href, $total);
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}
