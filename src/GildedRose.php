<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if ($item->name !== 'Aged Brie' and $item->name !== 'Backstage passes to a TAFKAL80ETC concert') {
                if ($item->quality > 0) {
                    if ($item->name !== 'Sulfuras, Hand of Ragnaros') {
                        $item = self::decreaseQuality($item);
                    }
                }
            } else {
                if ($item->quality < 50) {
                    $item = self::increaseQuality($item);
                    if ($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->sellIn < 11) {
                            if ($item->quality < 50) {
                                $item = self::increaseQuality($item);
                            }
                        }
                        if ($item->sellIn < 6) {
                            if ($item->quality < 50) {
                                $item = self::increaseQuality($item);
                            }
                        }
                    }
                }
            }

            if ($item->name !== 'Sulfuras, Hand of Ragnaros') {
                $item = self::decreaseSellIn($item);
            }

            if ($item->sellIn < 0) {
                if ($item->name !== 'Aged Brie') {
                    if ($item->name !== 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->quality > 0) {
                            if ($item->name !== 'Sulfuras, Hand of Ragnaros') {
                                $item = self::decreaseQuality($item);
                            }
                        }
                    } else {
                        $item = self::resetQuality($item);
                    }
                } else {
                    if ($item->quality < 50) {
                        $item = self::increaseQuality($item);
                    }
                }
            }
        }
    }
    
    private function decreaseQuality(Item $item) : Item
    {
        $item->quality = $item->quality - 1;
        return $item;
    }

    private function increaseQuality(Item $item) : Item
    {
        $item->quality = $item->quality + 1;
        return $item;
    }

    private function resetQuality(Item $item) : Item 
    {
        $item->quality = 0;
        return $item;
    }

    private function decreaseSellIn(Item $item) : Item
    {
        $item->sellIn = $item->sellIn - 1;
        return $item;
    }
}
