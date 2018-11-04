<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

class Paging
{
    /**
     * @var string
     */
    protected $href;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var string
     */
    protected $next;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var string
     */
    protected $previous;

    /**
     * @var int
     */
    protected $total;

    /**
     * Paging constructor.
     *
     * @param string $href
     * @param array  $items
     * @param int    $limit
     * @param string $next
     * @param int    $offset
     * @param string $previous
     * @param int    $total
     */
    public function __construct(
        string $href,
        array $items,
        int $limit,
        string $next,
        int $offset,
        string $previous,
        int $total
    ) {
        $this->href = $href;
        $this->items = $items;
        $this->limit = $limit;
        $this->next = $next;
        $this->offset = $offset;
        $this->previous = $previous;
        $this->total = $total;
    }

    /**
     * @param array $paging
     *
     * @return \Kerox\Spotify\Model\Paging
     */
    public static function create(array $paging): self
    {
        $items = [];
        foreach ($paging['items'] as $item) {
            if (isset($item['type'])) {
                $type = $item['type'] ?? null;
                if ($type === Album::TYPE) {
                    $items[] = Album::create($item);

                    continue;
                }

                if ($type === Artist::TYPE) {
                    $items[] = Artist::create($item);

                    continue;
                }

                if ($type === Track::TYPE) {
                    $items[] = Track::create($item);

                    continue;
                }

                if ($type === Playlist::TYPE) {
                    $items[] = Playlist::create($item);

                    continue;
                }
            } elseif (isset($item['added_at'])) {
                $items[] = SavedTrack::create($item);

                continue;
            }
        }

        $href = $paging['href'];
        $limit = $paging['limit'];
        $next = $paging['next'];
        $offset = $paging['offset'];
        $previous = $paging['previous'];
        $total = $paging['total'];

        return new self($href, $items, $limit, $next, $offset, $previous, $total);
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @var int
     *
     * @return mixed
     */
    public function getItem(int $key)
    {
        return $this->items[++$key];
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return string
     */
    public function getNext(): string
    {
        return $this->next;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return string
     */
    public function getPrevious(): string
    {
        return $this->previous;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}