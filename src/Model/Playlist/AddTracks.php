<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\Playlist;

use JsonSerializable;

class AddTracks implements JsonSerializable
{
    /**
     * @var array
     */
    protected $uris;

    /**
     * @var int|null
     */
    protected $position;

    /**
     * AddTracks constructor.
     */
    public function __construct(array $uris, ?int $position = null)
    {
        $this->uris = $uris;
        $this->position = $position;
    }

    /**
     * @return \Kerox\Spotify\Model\Playlist\AddTracks
     */
    public static function create(array $uris, ?int $position = null): self
    {
        return new self($uris, $position);
    }

    public function toArray(): array
    {
        $array = [
            'uris' => $this->uris,
            'position' => $this->position,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
