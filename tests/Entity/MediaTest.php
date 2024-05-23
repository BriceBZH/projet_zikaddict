<?php

namespace App\Tests\Entity;

use App\Entity\Media;
use PHPUnit\Framework\TestCase;


class MediaTest extends TestCase
{
    public function testGetUrl() {
        $media = new Media();
        $media->setUrl('Legend.png');
        $this->assertEquals('Legend.png', $media->getUrl());
    }

    public function testGetId() {
        $media = new Media();
        $media->setId(1);
        $this->assertEquals(1, $media->getId());
    }

    public function testGetAlt() {
        $media = new Media();
        $media->setAlt('Alpha Blondy');
        $this->assertEquals('Alpha Blondy', $media->getAlt());
    }

    public function testGetUrlSource() {
        $media = new Media();
        $media->setUrlSource('https://www.google.fr');
        $this->assertEquals('https://www.google.fr', $media->getUrlSource());
    }

}