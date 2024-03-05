<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserAlbumFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) {
        $users = $manager->getRepository(User::class)->findAll();
        $albums = $manager->getRepository(Album::class)->findAll();
        // Boucler sur les utilisateurs et associer aléatoirement des albums à chaque utilisateur
        foreach ($users as $user) {
            $userAlbums = $this->getRandomAlbums($albums);
            foreach ($userAlbums as $album) {
                $user->addAlbum($album);
            }
        }
        $manager->flush();
    }

    // Fonction pour sélectionner un nombre aléatoire d'albums
    private function getRandomAlbums($albums) {
        $randomAlbums = [];
        $numAlbumsToAdd = rand(1, count($albums));
        while (count($randomAlbums) < $numAlbumsToAdd) {
            $randomAlbum = $albums[array_rand($albums)];
            if (!in_array($randomAlbum, $randomAlbums)) {
                $randomAlbums[] = $randomAlbum;
            }
        }
        return $randomAlbums;
    }

    public function getDependencies() {
        return [
            UserFixtures::class,
            AlbumFixtures::class,
        ];
    }
}