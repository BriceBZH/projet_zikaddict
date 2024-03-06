<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AlbumFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) {
        $medias = $manager->getRepository(Media::class)->findAll();
        for ($count = 1; $count < 50; $count++) {
            $album = new Album();
            $album->setTitle("title " . $count);
            $album->setYear(2000 + $count);
            $album->setCreatedAt(new \DateTimeImmutable());
            $album->setUpdateAt(new \DateTimeImmutable());
            $randomMedia = $medias[array_rand($medias)];
            $album->setMedia($randomMedia);
            $manager->persist($album);
        }
        $manager->flush();
    }

    public function getDependencies() {
        return [
            MediaFixtures::class,
        ];
    }
}