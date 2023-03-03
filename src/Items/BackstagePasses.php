<?php

declare(strict_types=1);

namespace GildedRose\Items;

final class BackstagePasses extends DefaultItem
{
    const NAME = 'Backstage passes to a TAFKAL80ETC concert';

    public function __construct(public int $sellIn,public int $quality) 
    {
        parent::__construct(self::NAME, $sellIn, $quality);
    }

    public function updateQuality() : self
    {
        $this->increaseQuality();

        if ($this->sellIn < 11) {
            $this->increaseQuality();
        }
        
        if ($this->sellIn < 6) {
            $this->increaseQuality();
        }

        $this->decreaseSellIn();

        if ($this->sellIn < 0) {
            $this->resetQuality();
        }

        return $this;
    }
}
