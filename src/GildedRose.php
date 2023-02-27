<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    const AGED_BRIE = 'Aged Brie';

    const BACKSTAGE_PASSES = 'Backstage passes to a TAFKAL80ETC concert';

    const SULFURAS = 'Sulfuras, Hand of Ragnaros';

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
            if ($item->name !== self::AGED_BRIE and $item->name !== self::BACKSTAGE_PASSES) {
                if ($item->name !== self::SULFURAS) {
                    $item = self::decreaseQuality($item);
                }
            } else {                
                $item = self::increaseQuality($item);
                if ($item->name === self::BACKSTAGE_PASSES) {
                    if ($item->sellIn < 11) {
                        $item = self::increaseQuality($item);
                    }
                    if ($item->sellIn < 6) {
                        $item = self::increaseQuality($item);
                    }
                }
            }

            if ($item->name !== self::SULFURAS) {
                $item = self::decreaseSellIn($item);
            }

            if ($item->sellIn < 0) {
                if ($item->name !== self::AGED_BRIE) {
                    if ($item->name !== self::BACKSTAGE_PASSES) {
                        
                        if ($item->name !== self::SULFURAS) {
                            $item = self::decreaseQuality($item);
                        }
                        
                    } else {
                        $item = self::resetQuality($item);
                    }
                } else {
                    $item = self::increaseQuality($item);
                }
            }
        }
    }
    
    private function decreaseQuality(Item $item) : Item
    {
        if ($item->quality > 0) {
            $item->quality = $item->quality - 1;
        }

        return $item;
    }

    private function increaseQuality(Item $item) : Item
    {
        if ($item->quality < 50) {
            $item->quality = $item->quality + 1;
        }

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
