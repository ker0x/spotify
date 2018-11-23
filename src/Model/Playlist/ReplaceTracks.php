<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\Playlist;

use JsonSerializable;

class ReplaceTracks implements JsonSerializable
{
    /**
     * @var array
     */
    protected $uris = [];

    /**
     * Uris constructor.
     *
     * @param array $uris
     */
    public function __construct(array $uris)
    {
        $this->uris = $uris;
    }

    /**
     * @param array $uris
     *
     * @return \Kerox\Spotify\Model\Playlist\ReplaceTracks
     */
    public static function create(array $uris): self
    {
        return new self($uris);
    }

    /**
     * @param string $uri
     *
     * @return \Kerox\Spotify\Model\Playlist\ReplaceTracks
     */
    public function add(string $uri): self
    {
        $this->uris[] = $uri;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uris' => $this->uris,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
