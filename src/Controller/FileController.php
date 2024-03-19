<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Artist;
use App\Entity\Country;
use App\Repository\ArtistRepository;
use App\Repository\MediaRepository;
use App\Repository\CountryRepository;
use DateTime;

#[Route('/file')]
class FileController extends AbstractController
{
    #[Route('/download_model/{filename}', name: 'download_model', methods: ['GET', 'POST'])]
    public function download(string $filename): Response
    {
        $directory = $this->getParameter('kernel.project_dir') . '/assets/csv/';

        if (!file_exists($directory . '/' . $filename)) {
            throw $this->createNotFoundException('Le fichier n\'existe pas.');
        }

        return $this->file($directory . '/' . $filename);
    }

    #[Route('/upload_csv', name: 'upload_csv', methods: ['GET', 'POST'])]
    public function upload(Request $request, ArtistRepository $artistRepository, MediaRepository $mediaRepository, CountryRepository $countryRepository, EntityManagerInterface $entityManager): Response
    {
        // Récupérer le fichier uploadé
        $csvFile = $request->files->get('csv_file');

        // Vérifier si un fichier a été effectivement uploadé
        if (!$csvFile) {
            throw $this->createNotFoundException('Aucun fichier uploadé.');
        }

        // Vérifier si c'est bien un fichier CSV
        if ($csvFile->getClientOriginalExtension() !== 'csv') {
            throw $this->createNotFoundException('Le fichier n\'est pas un fichier CSV.');
        }

        // Parcourir les lignes du fichier CSV
        $csv = [];
        if (($handle = fopen($csvFile->getPathname(), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $data = array_map('utf8_encode', $data);
                $country = $data[1];
                $name = $data[3];
                $description = $data[4];
                $birthDate = $data[5];
                $deathDate = $data[6];
                $media = 11;
                $csv[] = ["country" => $country, "name" => $name, "description" => $description, "birthDate" => $birthDate, "deathDate" => $deathDate, "media" => $media];
            }
            fclose($handle);
        }

        foreach($csv as $item) {
            $artist = $artistRepository->findOneBy(['name' => $item['name']]);
            if(!$artist) { //si l'artiste n'existe pas on le créer
                $artist = new Artist();
                $artist->setName($item['name']);
                $artist->setDescription($item['description']);
                $artist->setBirthDate(DateTime::createFromFormat('Y-m-d', $item['birthDate']));
                if($item['deathDate'] === "0000-00-00") {
                    $deathDate = null;
                } else {
                    $deathDate = DateTime::createFromFormat('Y-m-d', $item['deathDate']);
                }
                $artist->setDeathDate($deathDate);
                $media = $mediaRepository->find($item['media']);
                $artist->setMedia($media);
                //on vérifie si le pays existe
                $country = $countryRepository->findOneBy(['name' => $item['country']]);
                if(!$country) { //le pays n'existe pas donc on l'ajoute
                    $country = new Country();
                    $country->setName($item['country']);
                    $entityManager->persist($country);
                    $entityManager->flush();
                }
                $artist->setCountry($country);
                $entityManager->persist($artist);
                $entityManager->flush();
            }
        }
        return new Response('Fichier CSV téléchargé et traité avec succès.');
    }

}
