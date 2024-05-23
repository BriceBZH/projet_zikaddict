<?php

namespace App\Tests\Entity;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use App\Entity\Format;
use App\Entity\Media;
use App\Entity\Country;
use PHPUnit\Framework\TestCase;


class AlbumTest extends TestCase
{
    public function testGetTitle() {
        $album = new Album();
        $album->setTitle('Uprising');
        $this->assertEquals('Uprising', $album->getTitle());
    }

    public function testGetId() {
        $album = new Album();
        $album->setId(1);
        $this->assertEquals(1, $album->getId());
    }

    public function testGetYear() {
        $album = new Album();
        $album->setYear('2014');
        $this->assertEquals('2014', $album->getYear());
    }

    public function testGetCreatedAt() {
        $album = new Album();
        $createdAt = new \DateTimeImmutable('2020-01-01 08:23:56');
        $album->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $album->getCreatedAt());
    }

    public function testIsValid() {
        $album = new Album();
        $album->setValid(true);
        $this->assertTrue($album->isValid());
    }

    public function testGetUpdateAt() {
        $album = new Album();
        $updateAt = new \DateTimeImmutable('2020-01-01 08:23:56');
        $album->setUpdateAt($updateAt);
        $this->assertEquals($updateAt, $album->getUpdateAt());
    }

    public function testGetMedia() {
        $album = new Album();
        $media = $this->createMock(Media::class);
        $album->setMedia($media);
        $this->assertSame($media, $album->getMedia());
    }

    public function testArtistsCollection() {
        $album = new Album();
        $artist = $this->createMock(Artist::class);
        $this->assertCount(0, $album->getArtists());
        $album->addArtist($artist);
        $this->assertCount(1, $album->getArtists());
        $this->assertTrue($album->getArtists()->contains($artist));
        $album->removeArtist($artist);
        $this->assertCount(0, $album->getArtists());
    }

    public function testSongsCollection() {
        $album = new Album();
        $song = $this->createMock(Song::class);
        $this->assertCount(0, $album->getSongs());
        $album->addSong($song);
        $this->assertCount(1, $album->getSongs());
        $this->assertTrue($album->getSongs()->contains($song));
        $album->removeSong($song);
        $this->assertCount(0, $album->getSongs());
    }

    public function testFormatsCollection() {
        $album = new Album();
        $format = $this->createMock(Format::class);
        $this->assertCount(0, $album->getFormats());
        $album->addFormat($format);
        $this->assertCount(1, $album->getFormats());
        $this->assertTrue($album->getFormats()->contains($format));
        $album->removeFormat($format);
        $this->assertCount(0, $album->getFormats());
    }
}