<?php

declare(strict_types=1);

namespace Kerox\Spotify\Response;

use Psr\Http\Message\ResponseInterface;

class FollowingResponse extends AbstractResponse
{
    /**
     * @var array
     */
    protected $ids;

    /**
     * @var array
     */
    protected $result;

    /**
     * FollowingResponse constructor.
     */
    public function __construct(ResponseInterface $response, array $ids)
    {
        $this->ids = $ids;

        parent::__construct($response);
    }

    public function getResult(): array
    {
        return $this->result;
    }

    public function isFollowing(string $id): bool
    {
        return $this->result[$id];
    }

    protected function parseResponse(array $content): void
    {
        $this->result = array_combine($this->ids, $content);
    }
}
