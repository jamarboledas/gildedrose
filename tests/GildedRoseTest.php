<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Items\AgedBrie;
use GildedRose\GildedRose;
use GildedRose\Item;
use GildedRose\Items\BackstagePasses;
use GildedRose\Items\DefaultItem;
use GildedRose\Items\Sulfuras;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testNotSpecialItemDecreasesQualityAndSellin(): void
    {
        // Given any item with any quality and any sellin.
        $items = [new DefaultItem('Random', 100, 100)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();

        // Then it decreases quality and selling by 1 
        $this->assertSame(99, $items[0]->quality);
        $this->assertSame(99, $items[0]->sellIn);
    }

    public function testNotSpecialItemWithSellinZeroDecreasesDouble(): void
    {
        // Given any item with any quality and sellin zero.
        $items = [new DefaultItem('Random', 0, 100)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        // Then it decreases quality by 2 and selling by 1
        $this->assertSame(98, $items[0]->quality);
        $this->assertSame(-1, $items[0]->sellIn);
    }

    public function testGivenQualityZeroItCanNotBeNegative(): void
    {
        // Given any item with any selling and quality zero.
        $items = [new DefaultItem('Random', 0, 0)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        // Then it keeps quality zero and decreases sellin by 1
        $this->assertSame(0, $items[0]->quality);
        $this->assertSame(-1, $items[0]->sellIn);
    }

    public function testAgedBrieInstanceIncreasesQualityTheOlderItGets(): void
    {
        // Given "Aged Brie" item with any quality and any sellin.
        $items = [new AgedBrie(100, 40)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        // Then it increases quality by 1 and decreases sellin by 1.
        $this->assertSame(41, $items[0]->quality);
        $this->assertSame(99, $items[0]->sellIn);
    }    

    public function testQualityOfAnItemIsNeverMoreThan50(): void
    {
        // Given any item with quality 50 and any sellin.
        $items = [new AgedBrie(100, 50)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();

        // Then it keeps quality 50 and decreases sellin by 1
        $this->assertSame(50, $items[0]->quality);
        $this->assertSame(99, $items[0]->sellIn);
    }

    public function testSulfurasNeverSoldNorDecreasesInQuality(): void
    {
        // Given item "Sulfuras, Hand of Ragnaros" with any quality and any sellin.
        $items = [new Sulfuras(100, 100)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        // Then it keeps quality and sellin
        $this->assertSame(100, $items[0]->quality);
        $this->assertSame(100, $items[0]->sellIn);
    }

    public function testBackstageIncreasesQualityTheOlderItGets(): void
    {
        // Given "Backstage passes to a TAFKAL80ETC concert" item with any quality and any sellin.
        $items = [new BackstagePasses(100, 40)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        // Then it increases quality by 1 and decreases sellin by 1.
        $this->assertSame(41, $items[0]->quality);
        $this->assertSame(99, $items[0]->sellIn);
    }

    public function testBackstagePassesIncreasesQualityBy2WhenThereAre10Days(): void
    {
        // Given "Backstage passes to a TAFKAL80ETC concert" item with quality 10 and any sellin.
        $items = [new BackstagePasses(10, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();

        // Then it increases quality by 2 and decreases sellin by 1.
        $this->assertSame(22, $items[0]->quality);
        $this->assertSame(9, $items[0]->sellIn);
    }

    public function testBackstagePassesIncreasesQualityBy2WhenThereBetween5And10Days(): void
    {
        // Given "Backstage passes to a TAFKAL80ETC concert" item with quality 7 and any sellin.
        $items = [new BackstagePasses(7, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        // Then it increases quality by 2 and decreases sellin by 1.
        $this->assertSame(22, $items[0]->quality);
        $this->assertSame(6, $items[0]->sellIn);
    }

    public function testBackstagePassesIncreasesQualityBy3WhenThereAre5Day(): void
    {
        // Given "Backstage passes to a TAFKAL80ETC concert" item with quality 5 and any sellin.
        $items = [new BackstagePasses(5, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();

        // Then it increases quality by 3 and decreases sellin by 1.
        $this->assertSame(23, $items[0]->quality);
        $this->assertSame(4, $items[0]->sellIn);
    }

    public function testBackstagePassesIncreasesQualityBy3WhenThereAreBetween5And0Days(): void
    {
        // Given "Backstage passes to a TAFKAL80ETC concert" item with quality 3 and any sellin.
        $items = [new BackstagePasses(3, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();

        // Then it increases quality by 3 and decreases sellin by 1.
        $this->assertSame(23, $items[0]->quality);
        $this->assertSame(2, $items[0]->sellIn);
    }

    public function testBackstagePassesQualityDropsToZeroWhenZeroDays(): void
    {
        // Given "Backstage passes to a TAFKAL80ETC concert" item with any quality and sellin 0.
        $items = [new BackstagePasses(0, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        // Then it drops quality to 0 and decreases sellin by 1.
        $this->assertSame(0, $items[0]->quality);
        $this->assertSame(-1, $items[0]->sellIn);
    }

    public function testBackstagePassesQualityDropsToZeroWhenLessThanZeroDays(): void
    {
        // Given "Backstage passes to a TAFKAL80ETC concert" item with any quality and sellin lower than 0.
        $items = [new BackstagePasses(-2, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        // Then it drops quality to 0 and decreases sellin by 1.
        $this->assertSame(0, $items[0]->quality);
        $this->assertSame(-3, $items[0]->sellIn);
    }
}
