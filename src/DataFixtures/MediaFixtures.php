<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MediaFixtures extends Fixture
{
    public function load(ObjectManager $manager) {
        for ($count = 0; $count < 10; $count++) {
            $media = new Media();
            $media->setAlt("alt" . $count);
            $media->setUrl("url" . $count);
            $manager->persist($media);
        }
        $manager->flush();
    }
}