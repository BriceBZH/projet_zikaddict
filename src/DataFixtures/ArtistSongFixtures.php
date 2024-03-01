<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Song;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArtistSongFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) {
        $artists = $manager->getRepository(Artist::class)->findAll();
        $songs = $manager->getRepository(Song::class)->findAll();
        // Boucler sur les chansons et associer aléatoirement des artistes à chaque chanson
        foreach ($songs as $song) {
            $songArtists = $this->getRandomArtists($artists);
            foreach ($songArtists as $artist) {
                $song->addArtist($artist);
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
            SongFixtures::class,
        ];
    }
}
