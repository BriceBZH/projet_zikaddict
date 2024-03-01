<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager) {
        for ($count = 0; $count < 10; $count++) {
            $genre = new Genre();
            $genre->setLibelle("libelle " . $count);
            $manager->persist($genre);
        }
        $manager->flush();
    }
}