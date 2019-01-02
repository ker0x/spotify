<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use DateTime;
use DateTimeInterface;
use DateTimeZone;

class SavedTrack
{
    /**
     * @var \DateTimeInterface
     */
    protected $addedAt;

    /**
     * @var \Kerox\Spotify\Model\User
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
     * @var \Kerox\Spotify\Model\Track
     */
    protected $track;

    /**
     * @var array
     */
    protected $videoThumbnail;

    /**
     * SavedTrack constructor.
     *
     * @param \DateTimeInterface             $addedAt
     * @param bool|null                      $isLocal
     * @param \Kerox\Spotify\Model\User|null $addedBy
     * @param \Kerox\Spotify\Model\Track     $track
     * @param array                          $videoThumbnail
     * @param string|null                    $primaryColor
     */
    public function __construct(
        DateTimeInterface $addedAt,
        Track $track,
        ?User $addedBy = null,
        array $videoThumbnail = [],
        bool $isLocal = false,
        ?string $primaryColor = null
    ) {
        $this->addedAt = $addedAt;
        $this->addedBy = $addedBy;
        $this->primaryColor = $primaryColor;
        $this->track = $track;
        $this->isLocal = $isLocal;
        $this->videoThumbnail = $videoThumbnail;
    }

    /**
     * @param array $savedTrack
     *
     * @return \Kerox\Spotify\Model\SavedTrack
     */
    public static function build(array $savedTrack): self
    {
        $addedAt = DateTime::createFromFormat(
            DateTime::ATOM,
            $savedTrack['added_at'],
            new DateTimeZone('UTC')
        );

        if (isset($savedTrack['added_by'])) {
            $addedBy = User::build($savedTrack['added_by']);
        }
        $isLocal = $savedTrack['is_local'] ?? false;
        $primaryColor = $savedTrack['primary_color'] ?? null;
        $track = Track::build($savedTrack['track']);

        $videoThumbnail = [];
        if (isset($savedTrack['video_thumbnail'])) {
            foreach ($savedTrack['video_thumbnail'] as $type => $url) {
                $videoThumbnail[] = External::build($type, $url);
            }
        }

        return new self($addedAt, $track, $addedBy ?? null, $videoThumbnail, $isLocal, $primaryColor);
    }

    /**
     * @return \DateTimeInterface
     */
    public function getAddedAt(): DateTimeInterface
    {
        return $this->addedAt;
    }

    /**
     * @return \Kerox\Spotify\Model\User
     */
    public function getAddedBy(): User
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
     * @return \Kerox\Spotify\Model\Track
     */
    public function getTrack(): Track
    {
        return $this->track;
    }

    /**
     * @return array
     */
    public function getVideoThumbnail(): array
    {
        return $this->videoThumbnail;
    }
}
