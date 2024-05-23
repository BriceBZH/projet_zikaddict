<?php

namespace App\Tests\Entity;

use App\Entity\Artist;
use App\Entity\Album;
use App\Entity\Song;
use App\Entity\Media;
use App\Entity\Country;
use PHPUnit\Framework\TestCase;


class ArtistTest extends TestCase
{
    public function testGetName() {
        $artist = new Artist();
        $artist->setName('Bob Dylan');
        $this->assertEquals('Bob Dylan', $artist->getName());
    }

    public function testGetId() {
        $artist = new Artist();
        $artist->setId(1);
        $this->assertEquals(1, $artist->getId());
    }

    public function testGetDescription() {
        $artist = new Artist();
        $artist->setDescription('Un chanteur reconnu');
        $this->assertEquals('Un chanteur reconnu', $artist->getDescription());
    }

    public function testGetBirthDate() {
        $artist = new Artist();
        $birthDate = new \DateTime('1990-01-01');
        $artist->setBirthDate($birthDate);
        $this->assertEquals($birthDate, $artist->getBirthDate());
    }

    public function testGetDeathDate() {
        $artist = new Artist();
        $deathDate = new \DateTime('2020-01-01');
        $artist->setDeathDate($deathDate);
        $this->assertEquals($deathDate, $artist->getDeathDate());
    }

    public function testGetMedia() {
        $artist = new Artist();
        $media = $this->createMock(Media::class);
        $artist->setMedia($media);
        $this->assertSame($media, $artist->getMedia());
    }

    public function testGetCountry() {
        $artist = new Artist();
        $country = $this->createMock(Country::class);
        $artist->setCountry($country);
        $this->assertSame($country, $artist->getCountry());
    }

    public function testIsValid() {
        $artist = new Artist();
        $artist->setValid(true);
        $this->assertTrue($artist->isValid());
    }

    public function testAlbumsCollection() {
        $artist = new Artist();
        $album = $this->createMock(Album::class);
        $this->assertCount(0, $artist->getAlbums());
        $artist->addAlbum($album);
        $this->assertCount(1, $artist->getAlbums());
        $this->assertTrue($artist->getAlbums()->contains($album));
        $artist->removeAlbum($album);
        $this->assertCount(0, $artist->getAlbums());
    }

    public function testSongsCollection() {
        $artist = new Artist();
        $song = $this->createMock(Song::class);
        $this->assertCount(0, $artist->getSongs());
        $artist->addSong($song);
        $this->assertCount(1, $artist->getSongs());
        $this->assertTrue($artist->getSongs()->contains($song));
        $artist->removeSong($song);
        $this->assertCount(0, $artist->getSongs());
    }
}