<?php

declare(strict_types=1);

namespace Kerox\Spotify\Interfaces;

interface QueryParametersInterface
{
    public const PARAMETER_MARKET = 'market';
    public const PARAMETER_COUNTRY = 'country';
    public const PARAMETER_LOCALE = 'locale';
    public const PARAMETER_TIMESTAMP = 'timestamp';
    public const PARAMETER_TIME_RANGE = 'time_range';

    public const PARAMETER_IDS = 'ids';
    public const PARAMETER_INCLUDE_GROUPS = 'include_groups';
    public const PARAMETER_SEED_ARTISTS = 'seed_artists';
    public const PARAMETER_SEED_GENRES = 'seed_genres';
    public const PARAMETER_SEED_TRACKS = 'seed_tracks';
    public const PARAMETER_QUERY = 'q';
    public const PARAMETER_TYPE = 'type';
    public const PARAMETER_INCLUDE_EXTERNAL = 'include_external';
    public const PARAMETER_AFTER = 'after';
    public const PARAMETER_FIELDS = 'fields';

    public const PARAMETER_LIMIT = 'limit';
    public const PARAMETER_OFFSET = 'offset';

    public const TIME_RANGE_SHORT = 'short_term';
    public const TIME_RANGE_MEDIUM = 'medium_term';
    public const TIME_RANGE_LONG = 'long_term';

    public const TIME_RANGE_VALUES = [
        self::TIME_RANGE_SHORT,
        self::TIME_RANGE_MEDIUM,
        self::TIME_RANGE_LONG,
    ];

    public const INCLUDE_GROUPS_ALBUM = 'album';
    public const INCLUDE_GROUPS_SINGLE = 'single';
    public const INCLUDE_GROUPS_APPEARS_ON = 'appears_on';
    public const INCLUDE_GROUPS_COMPILATION = 'compilation';

    public const INCLUDE_GROUPS_VALUES = [
        self::INCLUDE_GROUPS_ALBUM,
        self::INCLUDE_GROUPS_SINGLE,
        self::INCLUDE_GROUPS_APPEARS_ON,
        self::INCLUDE_GROUPS_COMPILATION,
    ];

    public const INCLUDE_EXTERNAL_AUDIO = 'audio';

    public const INCLUDE_EXTERNAL_VALUES = [
        self::INCLUDE_EXTERNAL_AUDIO,
    ];
}
