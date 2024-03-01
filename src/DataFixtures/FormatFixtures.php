<?php

namespace App\DataFixtures;

use App\Entity\Format;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FormatFixtures extends Fixture
{
    public function load(ObjectManager $manager) {
        for ($count = 0; $count < 10; $count++) {
            $format = new Format();
            $format->setLibelle("libelle " . $count);
            $manager->persist($format);
        }
        $manager->flush();
    }
}