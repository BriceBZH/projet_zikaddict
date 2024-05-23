<?php

namespace App\Tests\Entity;

use App\Entity\UserAlbumFormat;
use App\Entity\User;
use App\Entity\Album;
use App\Entity\Format;
use PHPUnit\Framework\TestCase;


class UserAlbumFormatTest extends TestCase
{
    public function testGetId() {
        $userAlbumFormat = new UserAlbumFormat();
        $userAlbumFormat->setId(1);
        $this->assertEquals(1, $userAlbumFormat->getId());
    }
    public function testGetUser() {
        $userAlbumFormat = new UserAlbumFormat();
        $user = $this->createMock(User::class);
        $userAlbumFormat->setUser($user);
        $this->assertSame($user, $userAlbumFormat->getUser());
    }

    public function testGetAlbum() {
        $userAlbumFormat = new UserAlbumFormat();
        $album = $this->createMock(Album::class);
        $userAlbumFormat->setAlbum($album);
        $this->assertSame($album, $userAlbumFormat->getAlbum());
    }

    public function testGetFormat() {
        $userAlbumFormat = new UserAlbumFormat();
        $format = $this->createMock(Format::class);
        $userAlbumFormat->setFormat($format);
        $this->assertSame($format, $userAlbumFormat->getFormat());
    }

}