<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

interface ModelInterface
{
    /**
     * @param array $model
     *
     * @return mixed
     */
    public static function build(array $model);
}
