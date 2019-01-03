<?php

declare(strict_types=1);

namespace Kerox\Spotify\Model;

use Kerox\Spotify\Factory\ItemFactory;
use Kerox\Spotify\Interfaces\ModelInterface;

class Paging implements ModelInterface
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
     * @var null|string
     */
    protected $next;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var null|string
     */
    protected $previous;

    /**
     * @var int
     */
    protected $total;

    /**
     * @var \Kerox\Spotify\Model\Cursor|null
     */
    protected $cursors;

    /**
     * Paging constructor.
     *
     * @param string                           $href
     * @param array                            $items
     * @param int                              $limit
     * @param string                           $next
     * @param int                              $offset
     * @param string                           $previous
     * @param int                              $total
     * @param \Kerox\Spotify\Model\Cursor|null $cursors
     */
    public function __construct(
        string $href,
        array $items,
        int $limit,
        ?string $next,
        int $offset,
        ?string $previous,
        int $total,
        ?Cursor $cursors
    ) {
        $this->href = $href;
        $this->items = $items;
        $this->limit = $limit;
        $this->next = $next;
        $this->offset = $offset;
        $this->previous = $previous;
        $this->total = $total;
        $this->cursors = $cursors;
    }

    /**
     * @param array $paging
     *
     * @return \Kerox\Spotify\Model\Paging
     */
    public static function build(array $paging): self
    {
        $items = [];
        if (isset($paging['items'])) {
            foreach ($paging['items'] as $item) {
                $items[] = ItemFactory::create($item);
            }
        }

        $cursors = null;
        if (isset($paging['cursors'])) {
            $cursors = Cursor::build($paging['cursors']);
        }

        $href = $paging['href'];
        $limit = $paging['limit'] ?? 0;
        $next = $paging['next'] ?? null;
        $offset = $paging['offset'] ?? 0;
        $previous = $paging['previous'] ?? null;
        $total = $paging['total'] ?? 0;

        return new self($href, $items, $limit, $next, $offset, $previous, $total, $cursors);
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
        return $this->items[$key];
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
    public function getNext(): ?string
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
    public function getPrevious(): ?string
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

    /**
     * @return \Kerox\Spotify\Model\Cursor|null
     */
    public function getCursors(): ?Cursor
    {
        return $this->cursors;
    }
}
