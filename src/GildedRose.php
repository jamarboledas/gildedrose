<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    public function __construct(
        private array $items
    ) {
    }

    public function updateQuality(): void
    {
        array_map(function($item) {
            return $item->updateQuality();
        }, $this->items);
    }
}
