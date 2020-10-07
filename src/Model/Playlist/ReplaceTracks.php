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
     */
    public function __construct(array $uris)
    {
        $this->uris = $uris;
    }

    /**
     * @return \Kerox\Spotify\Model\Playlist\ReplaceTracks
     */
    public static function create(array $uris): self
    {
        return new self($uris);
    }

    /**
     * @return \Kerox\Spotify\Model\Playlist\ReplaceTracks
     */
    public function add(string $uri): self
    {
        $this->uris[] = $uri;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'uris' => $this->uris,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
