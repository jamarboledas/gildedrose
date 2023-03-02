<?php

declare(strict_types=1);

namespace GildedRose\Items;

use GildedRose\Item;

final class DefaultItem extends Item
{
    public function __construct(public string $name, public int $sellIn,public int $quality) 
    {
        parent::__construct($name, $sellIn, $quality);
    }

    public function updateQuality() : self
    {
        $this->decreaseQuality();
        $this->decreaseSellIn();
        
        if ($this->sellIn < 0) {
            $this->decreaseQuality();
        }

        return $this;
    }

    private function decreaseSellIn() : self
    {
        $this->sellIn = $this->sellIn - 1;
        return $this;
    }

    private function decreaseQuality() : self
    {
        if ($this->quality > 0) {
            $this->quality = $this->quality - 1;
        }

        return $this;
    }
}
