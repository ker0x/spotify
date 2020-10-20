<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model\Playlist;

use JsonSerializable;

class ReorderTracks implements JsonSerializable
{
    /**
     * @var int
     */
    protected $rangeStart;

    /**
     * @var int|null
     */
    protected $rangeLength;

    /**
     * @var int
     */
    protected $insertBefore;

    /**
     * @var string|null
     */
    protected $snapshotId;

    /**
     * Reorder constructor.
     */
    public function __construct(int $rangeStart, int $insertBefore)
    {
        $this->rangeStart = $rangeStart;
        $this->insertBefore = $insertBefore;
    }

    /**
     * @return \Kerox\Spotify\Model\Playlist\ReorderTracks
     */
    public static function create(int $rangeStart, int $insertBefore): self
    {
        return new self($rangeStart, $insertBefore);
    }

    /**
     * @return \Kerox\Spotify\Model\Playlist\ReorderTracks
     */
    public function setRangeLength(int $rangeLength): self
    {
        $this->rangeLength = $rangeLength;

        return $this;
    }

    /**
     * @return \Kerox\Spotify\Model\Playlist\ReorderTracks
     */
    public function setSnapshotId(string $snapshotId): self
    {
        $this->snapshotId = $snapshotId;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'range_start' => $this->rangeStart,
            'range_length' => $this->rangeLength,
            'insert_before' => $this->insertBefore,
            'snapshot_id' => $this->snapshotId,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
