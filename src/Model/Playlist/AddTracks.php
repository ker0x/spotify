<?php

namespace Kerox\Spotify\Model\Playlist;

use JsonSerializable;

class AddTracks implements JsonSerializable
{
    /**
     * @var array
     */
    protected $uris;

    /**
     * @var null|int
     */
    protected $position;

    /**
     * AddTracks constructor.
     *
     * @param array    $uris
     * @param int|null $position
     */
    public function __construct(array $uris, ?int $position = null)
    {
        $this->uris = $uris;
        $this->position = $position;
    }

    /**
     * @param array    $uris
     * @param int|null $position
     *
     * @return \Kerox\Spotify\Model\Playlist\AddTracks
     */
    public static function create(array $uris, ?int $position = null): self
    {
        return new self($uris, $position);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'uris' => $this->uris,
            'position' => $this->position,
        ];

        return array_filter($array);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
