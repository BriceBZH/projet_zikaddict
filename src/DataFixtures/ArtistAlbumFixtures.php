<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Album;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArtistAlbumFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) {
        $artists = $manager->getRepository(Artist::class)->findAll();
        $albums = $manager->getRepository(Album::class)->findAll();
        // Boucler sur les albums et associer aléatoirement des artistes à chaque album
        foreach ($albums as $album) {
            $albumArtists = $this->getRandomArtists($artists);
            foreach ($albumArtists as $artist) {
                $album->addArtist($artist);
            }
        }
        $manager->flush();
    }

    // Fonction pour sélectionner un nombre aléatoire d'artistes
    private function getRandomArtists($artists) {
        $randomArtists = [];
        $numArtistsToAdd = rand(1, count($artists));
        while (count($randomArtists) < $numArtistsToAdd) {
            $randomArtist = $artists[array_rand($artists)];
            if (!in_array($randomArtist, $randomArtists)) {
                $randomArtists[] = $randomArtist;
            }
        }
        return $randomArtists;
    }

    public function getDependencies() {
        return [
            ArtistFixtures::class,
            AlbumFixtures::class,
        ];
    }
}
