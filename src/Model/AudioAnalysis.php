<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Interfaces\ModelInterface;
use Kerox\Spotify\Model\AudioAnalysis\Bar;
use Kerox\Spotify\Model\AudioAnalysis\Beat;
use Kerox\Spotify\Model\AudioAnalysis\Meta;
use Kerox\Spotify\Model\AudioAnalysis\Section;
use Kerox\Spotify\Model\AudioAnalysis\Segment;
use Kerox\Spotify\Model\AudioAnalysis\Tatum;
use Kerox\Spotify\Model\AudioAnalysis\Track as TrackAnalysis;

class AudioAnalysis implements ModelInterface
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

    /**
     * @param array $audioAnalysis
     *
     * @return \Kerox\Spotify\Model\AudioAnalysis
     */
    public static function build(array $audioAnalysis): self
    {
        $bars = [];
        foreach ($audioAnalysis['bars'] as $bar) {
            $bars[] = Bar::build($bar);
        }

        $beats = [];
        foreach ($audioAnalysis['beats'] as $beat) {
            $beats[] = Beat::build($beat);
        }

        $meta = Meta::build($audioAnalysis['meta']);

        $sections = [];
        foreach ($audioAnalysis['sections'] as $section) {
            $sections[] = Section::build($section);
        }

        $segments = [];
        foreach ($audioAnalysis['segments'] as $segment) {
            $segments[] = Segment::build($segment);
        }

        $tatums = [];
        foreach ($audioAnalysis['tatums'] as $tatum) {
            $tatums[] = Tatum::build($tatum);
        }

        $track = TrackAnalysis::build($audioAnalysis['track']);

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
     * @param int $index
     *
     * @return \Kerox\Spotify\Model\AudioAnalysis\Bar|null
     */
    public function getBar(int $index): ?Bar
    {
        return $this->bars[$index] ?? null;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Beat[]
     */
    public function getBeats(): array
    {
        return $this->beats;
    }

    /**
     * @param int $index
     *
     * @return \Kerox\Spotify\Model\AudioAnalysis\Beat|null
     */
    public function getBeat(int $index): ?Beat
    {
        return $this->beats[$index] ?? null;
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
     * @param int $index
     *
     * @return \Kerox\Spotify\Model\AudioAnalysis\Section|null
     */
    public function getSection(int $index): ?Section
    {
        return $this->sections[$index] ?? null;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Segment[]
     */
    public function getSegments(): array
    {
        return $this->segments;
    }

    /**
     * @param int $index
     *
     * @return \Kerox\Spotify\Model\AudioAnalysis\Segment|null
     */
    public function getSegment(int $index): ?Segment
    {
        return $this->segments[$index] ?? null;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Tatum[]
     */
    public function getTatums(): array
    {
        return $this->tatums;
    }

    /**
     * @param int $index
     *
     * @return \Kerox\Spotify\Model\AudioAnalysis\Tatum|null
     */
    public function getTatum(int $index): ?Tatum
    {
        return $this->tatums[$index] ?? null;
    }

    /**
     * @return \Kerox\Spotify\Model\AudioAnalysis\Track
     */
    public function getTrack(): TrackAnalysis
    {
        return $this->track;
    }
}
