<?php

namespace Kerox\Spotify\Model\Playlist;

use JsonSerializable;

class ReorderTracks implements JsonSerializable
{
    /**
     * @var int
     */
    protected $rangeStart;

    /**
     * @var null|int
     */
    protected $rangeLength;

    /**
     * @var int
     */
    protected $insertBefore;

    /**
     * @var null|string
     */
    protected $snapshotId;

    /**
     * Reorder constructor.
     *
     * @param int $rangeStart
     * @param int $insertBefore
     */
    public function __construct(int $rangeStart, int $insertBefore)
    {
        $this->rangeStart = $rangeStart;
        $this->insertBefore = $insertBefore;
    }

    /**
     * @param int $rangeStart
     * @param int $insertBefore
     *
     * @return \Kerox\Spotify\Model\Playlist\ReorderTracks
     */
    public static function create(int $rangeStart, int $insertBefore): self
    {
        return new self($rangeStart, $insertBefore);
    }

    /**
     * @param int $rangeLength
     *
     * @return \Kerox\Spotify\Model\Playlist\ReorderTracks
     */
    public function setRangeLength(int $rangeLength): self
    {
        $this->rangeLength = $rangeLength;

        return $this;
    }

    /**
     * @param string $snapshotId
     *
     * @return \Kerox\Spotify\Model\Playlist\ReorderTracks
     */
    public function setSnapshotId(string $snapshotId): self
    {
        $this->snapshotId = $snapshotId;

        return $this;
    }

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
