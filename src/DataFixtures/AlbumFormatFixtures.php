<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Format;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AlbumFormatFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) {
        $albums = $manager->getRepository(Album::class)->findAll();
        $formats = $manager->getRepository(Format::class)->findAll();
        // Boucler sur les albums et associer aléatoirement des formats à chaque album
        foreach ($albums as $album) {
            $albumFormats = $this->getRandomFormats($formats);
            foreach ($albumFormats as $format) {
                $album->addFormat($format);
            }
        }
        $manager->flush();
    }

    // Fonction pour sélectionner un nombre aléatoire de formats
    private function getRandomFormats($formats) {
        $randomFormats = [];
        $numFormatsToAdd = rand(1, count($formats));
        while (count($randomFormats) < $numFormatsToAdd) {
            $randomFormat = $formats[array_rand($formats)];
            if (!in_array($randomFormat, $randomFormats)) {
                $randomFormats[] = $randomFormat;
            }
        }
        return $randomFormats;
    }

    public function getDependencies() {
        return [
            AlbumFixtures::class,
            FormatFixtures::class,
        ];
    }
}