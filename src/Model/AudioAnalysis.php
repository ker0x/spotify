<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Model\AudioAnalysis\Bar;
use Kerox\Spotify\Model\AudioAnalysis\Beat;
use Kerox\Spotify\Model\AudioAnalysis\Meta;
use Kerox\Spotify\Model\AudioAnalysis\Section;
use Kerox\Spotify\Model\AudioAnalysis\Segment;
use Kerox\Spotify\Model\AudioAnalysis\Tatum;
use Kerox\Spotify\Model\AudioAnalysis\Track as TrackAnalysis;

class AudioAnalysis
{
    /**
     * @var \Kerox\Spotify\Model\AudioAnalysis\Bar[]
     */
    protected $bars;

    /**
     * @var \Kerox\Spotify\Model\AudioAnalysis\Beat[]
     */
    protected $beats;

    /**
     * @var \Kerox\Spotify\Model\AudioAnalysis\Meta
     */
    protected $meta;

    /**
     * @var \Kerox\Spotify\Model\AudioAnalysis\Section[]
     */
    protected $sections;

    /**
     * @var \Kerox\Spotify\Model\AudioAnalysis\Segment[]
     */
    protected $segments;

    /**
     * @var \Kerox\Spotify\Model\AudioAnalysis\Tatum[]
     */
    protected $tatums;

    /**
     * @var \Kerox\Spotify\Model\AudioAnalysis\Track
     */
    protected $track;

    /**
     * AudioAnalysis constructor.
     *
     * @param \Kerox\Spotify\Model\AudioAnalysis\Bar[]     $bars
     * @param \Kerox\Spotify\Model\AudioAnalysis\Beat[]    $beats
     * @param \Kerox\Spotify\Model\AudioAnalysis\Meta      $meta
     * @param \Kerox\Spotify\Model\AudioAnalysis\Section[] $sections
     * @param \Kerox\Spotify\Model\AudioAnalysis\Segment[] $segments
     * @param \Kerox\Spotify\Model\AudioAnalysis\Tatum[]   $tatums
     * @param \Kerox\Spotify\Model\AudioAnalysis\Track     $track
     */
    public function __construct(
        array $bars,
        array $beats,
        Meta $meta,
        array $sections,
        array $segments,
        array $tatums,
        TrackAnalysis $track
    ) {
        $this->bars = $bars;
        $this->beats = $beats;
        $this->meta = $meta;
        $this->sections = $sections;
        $this->segments = $segments;
        $this->tatums = $tatums;
        $this->track = $track;
    }

    public static function create(array $audioAnalysis): self
    {
        $bars = [];
        foreach ($audioAnalysis['bars'] as $bar) {
            $bars[] = Bar::create($bar);
        }

        $beats = [];
        foreach ($audioAnalysis['beats'] as $beat) {
            $beats[] = Beat::create($beat);
        }

        $meta = Meta::create($audioAnalysis['meta']);

        $sections = [];
        foreach ($audioAnalysis['sections'] as $section) {
            $sections[] = Section::create($section);
        }

        $segments = [];
        foreach ($audioAnalysis['segments'] as $segment) {
            $segments[] = Segment::create($segment);
        }

        $tatums = [];
        foreach ($audioAnalysis['tatums'] as $tatum) {
            $tatums[] = Tatum::create($tatum);
        }

        $track = TrackAnalysis::create($audioAnalysis['track']);

        return new self($bars, $beats, $meta, $sections, $segments, $tatums, $track);
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Bar[]
     */
    public function getBars(): array
    {
        return $this->bars;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Beat[]
     */
    public function getBeats(): array
    {
        return $this->beats;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Meta
     */
    public function getMeta(): Meta
    {
        return $this->meta;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Section[]
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Segment[]
     */
    public function getSegments(): array
    {
        return $this->segments;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Tatum[]
     */
    public function getTatums(): array
    {
        return $this->tatums;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Track
     */
    public function getTrack(): TrackAnalysis
    {
        return $this->track;
    }
}
