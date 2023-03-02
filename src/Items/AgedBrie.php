<?php

declare(strict_types=1);

namespace GildedRose\Items;

use GildedRose\Item;

final class AgedBrie extends Item
{
    const NAME = 'Aged Brie';

    public function __construct(public int $sellIn,public int $quality) 
    {
        parent::__construct(self::NAME, $sellIn, $quality);
    }

    public function updateQuality() : self
    {
        $this->increaseQuality();
        $this->decreaseSellIn();
        
        if ($this->sellIn < 0) {
            $this->increaseQuality();
        }

        return $this;
    }

    private function increaseQuality() : self
    {
        if ($this->quality < 50) {
            $this->quality = $this->quality + 1;
        }

        return $this;
    }

    private function decreaseSellIn() : self
    {
        $this->sellIn = $this->sellIn - 1;
        return $this;
    }
}
