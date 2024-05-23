<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\UserAlbumFormat;
use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{
    public function testGetUsername() {
        $user = new User();
        $user->setUsername('Administrateur');
        $this->assertEquals('Administrateur', $user->getUsername());
    }

    public function testGetId() {
        $user = new User();
        $user->setId(1);
        $this->assertEquals(1, $user->getId());
    }

    public function testGetEmail() {
        $user = new User();
        $user->setEmail('test.test@test.fr');
        $this->assertEquals('test.test@test.fr', $user->getEmail());
    }

    public function testIsVerified() {
        $user = new User();
        $user->setIsVerified(true);
        $this->assertTrue($user->isVerified());
    }

    public function testGetUserIdentifier() {
        $user = new User();
        $user->setUsername('testuser');
        $this->assertEquals('testuser', $user->getUserIdentifier());
    }

    public function testGetRoles() {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        $roles = $user->getRoles();
        $this->assertContains('ROLE_ADMIN', $roles);
        $this->assertContains('ROLE_USER', $roles);
        $this->assertCount(2, $roles); 
    }

    public function testGetPassword() {
        $user = new User();
        $user->setPassword("fmlhsfhsd€#[{|[{|{4654");
        $this->assertEquals("fmlhsfhsd€#[{|[{|{4654", $user->getPassword());
    }

    public function testGetCreatedAt() {
        $user = new User();
        $createdAt = new \DateTimeImmutable('2020-01-01 08:23:56');
        $user->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $user->getCreatedAt());
    }

    public function testUserAlbumFormats() {
        $user = new User();
        $userAlbumFormats = $this->createMock(UserAlbumFormat::class);
        $this->assertCount(0, $user->getUserAlbumFormats());
        $user->addUserAlbumFormat($userAlbumFormats);
        $this->assertCount(1, $user->getUserAlbumFormats());
        $this->assertTrue($user->getUserAlbumFormats()->contains($userAlbumFormats));
        $user->removeUserAlbumFormat($userAlbumFormats);
        $this->assertCount(0, $user->getUserAlbumFormats());
    }
}