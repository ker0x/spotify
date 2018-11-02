<?php

declare(strict_types=1);

namespace Kerox\Spotify\Interfaces;

interface TuneableTrackInterface
{
    public const ATTR_ACOUSTICNESS = 'acousticness';
    public const ATTR_DANCEABILITY = 'danceability';
    public const ATTR_DURATION_MS = 'duration_ms';
    public const ATTR_ENERGY = 'energy';
    public const ATTR_INSTRUMENTALNESS = 'instrumentalness';
    public const ATTR_KEY = 'key';
    public const ATTR_LIVENESS = 'liveness';
    public const ATTR_LOUDNESS = 'loudness';
    public const ATTR_MODE = 'mode';
    public const ATTR_POPULARITY = 'popularity';
    public const ATTR_SPEECHINESS = 'speechiness';
    public const ATTR_TEMPO = 'tempo';
    public const ATTR_TIME_SIGNATURE = 'time_signature';
    public const ATTR_VALENCE = 'valence';
}
