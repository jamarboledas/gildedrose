<?php

declare(strict_types=1);

namespace GildedRose\Items;

use GildedRose\Item;

final class Sulfuras extends Item
{
    const NAME = 'Sulfuras, Hand of Ragnaros';

    public function __construct(public int $sellIn,public int $quality) 
    {
        parent::__construct(self::NAME, $sellIn, $quality);
    }

    public function updateQuality() : self
    {
        $this->increaseQuality();
        if ($this->sellIn < 0) {
            $this->resetQuality();
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

    private function resetQuality() : self 
    {
        $this->quality = 0;
        return $this;
    }
}
