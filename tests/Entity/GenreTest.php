<?php

namespace App\Tests\Entity;

use App\Entity\Genre;
use PHPUnit\Framework\TestCase;

class GenreTest extends TestCase
{
    public function testGetLibelle() {
        $genre = new Genre();
        $genre->setLibelle('Rock');
        $this->assertEquals('Rock', $genre->getLibelle());
    }

    public function testSetLibelle() {
        $genre = new Genre();
        $genre->setLibelle('Rock');
        $this->assertEquals('Rock', $genre->getLibelle());
        $genre->setLibelle('Reggae');
        $this->assertEquals('Reggae', $genre->getLibelle());
    }

    public function testGetId() {
        $genre = new Genre();
        $genre->setId(1);
        $this->assertEquals(1, $genre->getId());
    }
}