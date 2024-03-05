<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail("test.test@test.test");
        $user->setPassword("test");
        $user->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($user);
        $manager->flush();
    }
}