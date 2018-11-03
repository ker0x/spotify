<?php

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
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array                               $ids
     */
    public function __construct(ResponseInterface $response, array $ids)
    {
        $this->ids = $ids;

        parent::__construct($response);
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function isFollowing(string $id): bool
    {
        return $this->result[$id];
    }

    /**
     * @param array $content
     */
    protected function parseResponse(array $content): void
    {
        $this->result = array_combine($this->ids, $content);
    }
}
