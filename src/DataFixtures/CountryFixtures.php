<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager) {
        for ($count = 0; $count < 100; $count++) {
            $country = new Country();
            $country->setName("Name " . $count);
            $manager->persist($country);
        }
        $manager->flush();
    }
}