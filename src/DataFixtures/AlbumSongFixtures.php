<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Song;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AlbumSongFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) {
        $albums = $manager->getRepository(Album::class)->findAll();
        $songs = $manager->getRepository(Song::class)->findAll();
        // Boucler sur les albums et associer aléatoirement des chansons à chaque album
        foreach ($albums as $album) {
            $albumSongs = $this->getRandomSongs($songs);
            foreach ($albumSongs as $song) {
                $album->addSong($song);
            }
        }
        $manager->flush();
    }

    // Fonction pour sélectionner un nombre aléatoire de chansons
    private function getRandomSongs($songs) {
        $randomSongs = [];
        $numSongsToAdd = rand(1, count($songs));
        while (count($randomSongs) < $numSongsToAdd) {
            $randomSong = $songs[array_rand($songs)];
            if (!in_array($randomSong, $randomSongs)) {
                $randomSongs[] = $randomSong;
            }
        }
        return $randomSongs;
    }

    public function getDependencies() {
        return [
            AlbumFixtures::class,
            SongFixtures::class,
        ];
    }
}
