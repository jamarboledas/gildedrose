<?php

declare(strict_types=1);

namespace GildedRose\Items;

final class Sulfuras extends DefaultItem
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
}
