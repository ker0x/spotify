<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

class PlayHistory
{
    /**
     * @var \Kerox\Spotify\Model\Track
     */
    protected $track;

    /**
     * @var \DateTimeInterface
     */
    protected $playedAt;

    /**
     * @var \Kerox\Spotify\Model\Context
     */
    protected $context;

    /**
     * PlayHistory constructor.
     *
     * @param \Kerox\Spotify\Model\Track   $track
     * @param \DateTimeInterface           $playedAt
     * @param \Kerox\Spotify\Model\Context $context
     */
    public function __construct(Track $track, DateTimeInterface $playedAt, Context $context)
    {
        $this->track = $track;
        $this->playedAt = $playedAt;
        $this->context = $context;
    }

    /**
     * @param array $playHistory
     *
     * @return \Kerox\Spotify\Model\PlayHistory
     */
    public static function create(array $playHistory): self
    {
        $track = Track::create($playHistory['track']);
        $playedAt = DateTimeImmutable::createFromFormat(
            DateTimeInterface::ATOM,
            $playHistory['played_at'],
            DateTimeZone::UTC
        );
        $context = Context::create($playHistory['context']);

        return new self($track, $playedAt, $context);
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
    public function getPlayedAt(): DateTimeInterface
    {
        return $this->playedAt;
    }

    /**
     * @return \Kerox\Spotify\Model\Context
     */
    public function getContext(): Context
    {
        return $this->context;
    }
}