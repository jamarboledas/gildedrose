<?php

declare(strict_types=1);

namespace GildedRose\Items;

final class AgedBrie extends DefaultItem
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
}
