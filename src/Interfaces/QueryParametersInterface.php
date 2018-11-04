<?php

declare(strict_types=1);

namespace Kerox\Spotify\Interfaces;

interface QueryParametersInterface
{
    public const PARAMETER_MARKET = 'market';
    public const PARAMETER_COUNTRY = 'country';
    public const PARAMETER_LOCALE = 'locale';
    public const PARAMETER_TIMESTAMP = 'timestamp';

    public const PARAMETER_IDS = 'ids';
    public const PARAMETER_INCLUDE_GROUPS = 'include_groups';
    public const PARAMETER_SEED_ARTISTS = 'seed_artists';
    public const PARAMETER_SEED_GENRES = 'seed_genres';
    public const PARAMETER_SEED_TRACKS = 'seed_tracks';
    public const PARAMETER_Q = 'q';
    public const PARAMETER_TYPE = 'type';
    public const PARAMETER_INCLUDE_EXTERNAL = 'include_external';
    public const PARAMETER_AFTER = 'after';

    public const PARAMETER_LIMIT = 'limit';
    public const PARAMETER_OFFSET = 'offset';
}
