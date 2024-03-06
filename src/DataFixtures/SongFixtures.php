<?php

namespace App\DataFixtures;

use App\Entity\Song;
use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SongFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) {
        $genres = $manager->getRepository(Genre::class)->findAll();
        for ($count = 1; $count < 100; $count++) {
            $song = new Song();
            $song->setTitle("title " . $count);
            $song->setDescription("description " . $count);
            $song->setDuration($count);
            $randomGenre = $genres[array_rand($genres)];
            $song->setGenre($randomGenre);
            $manager->persist($song);
        }
        $manager->flush();
    }

    public function getDependencies() {
        return [
            GenreFixtures::class,
        ];
    }
}