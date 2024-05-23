<?php

namespace App\Tests\Entity;

use App\Entity\Song;
use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Genre;
use App\Entity\Country;
use PHPUnit\Framework\TestCase;


class SongTest extends TestCase
{
    public function testGetTitle() {
        $song = new Song();
        $song->setTitle('Exodus');
        $this->assertEquals('Exodus', $song->getTitle());
    }

    public function testGetId() {
        $song = new Song();
        $song->setId(1);
        $this->assertEquals(1, $song->getId());
    }

    public function testIsValid() {
        $song = new Song();
        $song->setValid(true);
        $this->assertTrue($song->isValid());
    }

    public function testGetDescription() {
        $song = new Song();
        $song->setDescription('Une chanson sur la paix');
        $this->assertEquals('Une chanson sur la paix', $song->getDescription());
    }

    public function testGetDuration() {
        $song = new Song();
        $song->setDuration('150');
        $this->assertEquals('150', $song->getDuration());
    }

    public function testGetGenre() {
        $song = new Song();
        $genre = $this->createMock(Genre::class);
        $song->setGenre($genre);
        $this->assertSame($genre, $song->getGenre());
    }

    public function testAlbumsCollection() {
        $song = new Song();
        $album = $this->createMock(Album::class);
        $this->assertCount(0, $song->getAlbums());
        $song->addAlbum($album);
        $this->assertCount(1, $song->getAlbums());
        $this->assertTrue($song->getAlbums()->contains($album));
        $song->removeAlbum($album);
        $this->assertCount(0, $song->getAlbums());
    }

    public function testArtistsCollection() {
        $song = new Song();
        $artist = $this->createMock(Artist::class);
        $this->assertCount(0, $song->getArtists());
        $song->addArtist($artist);
        $this->assertCount(1, $song->getArtists());
        $this->assertTrue($song->getArtists()->contains($artist));
        $song->removeArtist($artist);
        $this->assertCount(0, $song->getArtists());
    }
}