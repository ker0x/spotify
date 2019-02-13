<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Kerox\Spotify\Interfaces\ModelInterface;

class SavedTrack implements ModelInterface
{
    /**
     * @var \Kerox\Spotify\Model\Track
     */
    protected $track;

    /**
     * @var \DateTimeInterface|null
     */
    protected $addedAt;

    /**
     * @var \Kerox\Spotify\Model\User|null
     */
    protected $addedBy;

    /**
     * @var bool
     */
    protected $isLocal;

    /**
     * @var string|null
     */
    protected $primaryColor;

    /**
     * @var array
     */
    protected $videoThumbnail;

    /**
     * SavedTrack constructor.
     *
     * @param \Kerox\Spotify\Model\Track     $track
     * @param \DateTimeInterface|null        $addedAt
     * @param \Kerox\Spotify\Model\User|null $addedBy
     * @param array                          $videoThumbnail
     * @param bool|null                      $isLocal
     * @param string|null                    $primaryColor
     */
    public function __construct(
        Track $track,
        ?DateTimeInterface $addedAt = null,
        ?User $addedBy = null,
        array $videoThumbnail = [],
        bool $isLocal = false,
        ?string $primaryColor = null
    ) {
        $this->track = $track;
        $this->addedAt = $addedAt;
        $this->addedBy = $addedBy;
        $this->videoThumbnail = $videoThumbnail;
        $this->isLocal = $isLocal;
        $this->primaryColor = $primaryColor;
    }

    /**
     * @param array $savedTrack
     *
     * @return \Kerox\Spotify\Model\SavedTrack
     */
    public static function build(array $savedTrack): self
    {
        $track = Track::build($savedTrack['track']);
        $addedAt = DateTime::createFromFormat(
            DateTime::ATOM,
            $savedTrack['added_at'],
            new DateTimeZone('UTC')
        ) ?: null;

        $addedBy = null;
        if (isset($savedTrack['added_by'])) {
            $addedBy = User::build($savedTrack['added_by']);
        }

        $videoThumbnail = [];
        if (isset($savedTrack['video_thumbnail'])) {
            foreach ($savedTrack['video_thumbnail'] as $type => $url) {
                $videoThumbnail[] = External::build([$type, $url]);
            }
        }
        $isLocal = $savedTrack['is_local'] ?? false;
        $primaryColor = $savedTrack['primary_color'] ?? null;

        return new self($track, $addedAt, $addedBy, $videoThumbnail, $isLocal, $primaryColor);
    }

    /**
     * @return \Kerox\Spotify\Model\Track
     */
    public function getTrack(): Track
    {
        return $this->track;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getAddedAt(): ?DateTimeInterface
    {
        return $this->addedAt;
    }

    /**
     * @return \Kerox\Spotify\Model\User|null
     */
    public function getAddedBy(): ?User
    {
        return $this->addedBy;
    }

    /**
     * @return bool
     */
    public function isLocal(): bool
    {
        return $this->isLocal;
    }

    /**
     * @return string|null
     */
    public function getPrimaryColor(): ?string
    {
        return $this->primaryColor;
    }

    /**
     * @return array
     */
    public function getVideoThumbnail(): array
    {
        return $this->videoThumbnail;
    }
}
