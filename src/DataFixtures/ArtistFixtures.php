<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Media;
use App\Entity\Artist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArtistFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) {
        $medias = $manager->getRepository(Media::class)->findAll();
        $countries = $manager->getRepository(Country::class)->findAll();
        for ($count = 1; $count < 50; $count++) {
            $artist = new Artist();
            $artist->setName("name " . $count);
            $artist->setDescription("description " . $count);
            $artist->setBirthDate(new \DateTimeImmutable());
            $artist->setDeathDate(new \DateTimeImmutable());
            $artist->setDead(1);
            $randomMedia = $medias[array_rand($medias)];
            $randomCountry = $countries[array_rand($countries)];
            $artist->setMedia($randomMedia);
            $artist->setCountry($randomCountry);
            $manager->persist($artist);
        }
        $manager->flush();
    }

    public function getDependencies() {
        return [
            MediaFixtures::class,
        ];
    }
}