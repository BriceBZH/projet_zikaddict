<?php

namespace App\Tests\Entity;

use App\Entity\Format;
use App\Entity\Album;
use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase
{
    public function testGetLibelle() {
        $format = new Format();
        $format->setLibelle('33T');
        $this->assertEquals('33T', $format->getLibelle());
    }

    public function testSetLibelle() {
        $format = new Format();
        $format->setLibelle('33T');
        $this->assertEquals('33T', $format->getLibelle());
        $format->setLibelle('45T');
        $this->assertEquals('45T', $format->getLibelle());
    }

    public function testGetId() {
        $format = new Format();
        $format->setId(1);
        $this->assertEquals(1, $format->getId());
    }

    public function testAlbumsCollection() {
        $format = new Format();
        $album = $this->createMock(Album::class);
        $this->assertCount(0, $format->getAlbums());
        $format->addAlbum($album);
        $this->assertCount(1, $format->getAlbums());
        $this->assertTrue($format->getAlbums()->contains($album));
        $format->removeAlbum($album);
        $this->assertCount(0, $format->getAlbums());
    }
}