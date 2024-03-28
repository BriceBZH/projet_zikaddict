<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Artist;
use App\Entity\Country;
use App\Entity\Album;
use App\Entity\Genre;
use App\Entity\Song;
use App\Entity\Format;
use App\Repository\ArtistRepository;
use App\Repository\UserAlbumFormatRepository;
use App\Repository\MediaRepository;
use App\Repository\CountryRepository;
use App\Repository\FormatRepository;
use App\Repository\UserRepository;
use App\Repository\AlbumRepository;
use App\Repository\SongRepository;
use App\Repository\GenreRepository;
use Dompdf\Dompdf;
use DateTime;
#[Route('/file')]
class FileController extends AbstractController
{
    #[Route('/download_model/{filename}', name: 'download_model', methods: ['GET'])]
    public function download(string $filename): Response
    {
        $directory = $this->getParameter('kernel.project_dir') . '/assets/csv/';

        if (!file_exists($directory . '/' . $filename)) {
            throw $this->createNotFoundException('Le fichier n\'existe pas.');
        }

        return $this->file($directory . '/' . $filename);
    }

    #[Route('/download_csv/{filename}/{idUser}', name: 'download_csv', methods: ['GET'])]
    public function downloadCSV(string $filename, int $idUser, UserAlbumFormatRepository $userAlbumFormatRepository): Response
    {
        $userAlbumFormats = $userAlbumFormatRepository->findBy(
            [], 
            ['format' => 'ASC']
        );

        // usort($userAlbumFormats, function($a, $b) {
        //     // Accéder au champ "format" de chaque objet et comparer les valeurs
        //     return strcmp($a->getFormat()->getLibelle(), $b->getFormat()->getLibelle());
        // });

        $callback = function () use ($userAlbumFormats) {
            $handle = fopen('php://output', 'w+');
            fputcsv($handle, ['Artists', 'Title', 'Year', 'Format'], ';');
        
            foreach ($userAlbumFormats as $userAlbumFormat) {
                $artists = "";
                $artistsAlbum = $userAlbumFormat->getAlbum()->getArtists();
                foreach ($artistsAlbum as $artist) {
                    $artists .= $artist->getName() . ', ';
                }
                $artists = rtrim($artists, ', ');
        
                $line = [
                    $artists,
                    $userAlbumFormat->getAlbum()->getTitle(),
                    $userAlbumFormat->getAlbum()->getYear(),
                    $userAlbumFormat->getFormat()->getLibelle()
                ];
                fputcsv($handle, $line, ';');
            }
            fclose($handle);
        };
        $response = new StreamedResponse($callback);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        ));

        return $response;
    }

    #[Route('/download_pdf/{filename}/{idUser}', name: 'download_pdf', methods: ['GET'])]
    public function downloadPDF(string $filename, int $idUser, UserAlbumFormatRepository $userAlbumFormatRepository, ): Response
    {
        // $userAlbumFormats = $userAlbumFormatRepository->findAll();
        $userAlbumFormats = $userAlbumFormatRepository->findBy(
            [], 
            ['format' => 'ASC']
        );
        $dompdf = new Dompdf();
        $html = '<table>';
        foreach ($userAlbumFormats as $userAlbumFormat) {
            $currentFormat = $userAlbumFormat->getFormat()->getLibelle(); //format actuel

            if(!isset($previousFormat)) { //1ere ligne
                $previousFormat = "";
            }
            if($currentFormat !== $previousFormat) {
                $html .= '<tr><td colspan="3"><strong>'.$currentFormat.'</strong></td></tr>';
                $previousFormat = $currentFormat;
            }
            
            $artists = "";
            $artistsAlbum = $userAlbumFormat->getAlbum()->getArtists();
            foreach ($artistsAlbum as $artist) {
                $artists .= $artist->getName() . ', ';
            }
            $artists = rtrim($artists, ', ');
            $html .= '<tr><td>'.$artists.'</td><td>'.$userAlbumFormat->getAlbum()->getTitle().'</td><td>'.$userAlbumFormat->getAlbum()->getYear().'</td></tr>';
        }
        $html .= '</table></body></html>';
        $dompdf->loadHtml($html);
        $dompdf->render();
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    #[Route('/upload_csv', name: 'upload_csv', methods: ['GET', 'POST'])]
    public function upload(Request $request, ArtistRepository $artistRepository, MediaRepository $mediaRepository, GenreRepository $genreRepository, SongRepository $songRepository, CountryRepository $countryRepository, AlbumRepository $albumRepository, FormatRepository $formatRepository, EntityManagerInterface $entityManager): Response
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
            fgetcsv($handle, 1000, ";");
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $data = array_map('utf8_encode', $data);
                $artistName = $data[0];
                $artistCountry = $data[1];
                $artistDescription = $data[2];
                $artistBirthDate = $data[3];
                $artistDeathDate = $data[4];
                $artistMedia = 11;
                $albumTitle = $data[5];
                $albumYear = (int) $data[6];
                $albumMedia = 11;
                $albumFormat = $data[7];
                $songGenre = $data[8];
                $songTitle = $data[9];
                if(isset($data[10])) {
                    $songDescription = $data[10];
                } else {
                    $songDescription = "";
                }
                if(isset($data[11])) {
                    $songDuration = (int) $data[11];
                } else {
                    $songDuration = 0;
                }    
                $csv[] = [
                    "artistName" => $artistName,
                    "artistCountry" => $artistCountry,
                    "artistDescription" => $artistDescription,
                    "artistBirthDate" => $artistBirthDate,
                    "artistDeathDate" => $artistDeathDate,
                    "artistMedia" => $artistMedia,
                    "albumTitle" => $albumTitle,
                    "albumYear" => $albumYear,
                    "albumMedia" => $albumMedia,
                    "albumFormat" => $albumFormat,
                    "songGenre" => $songGenre,
                    "songTitle" => $songTitle,
                    "songDescription" => $songDescription,
                    "songDuration" => $songDuration,
                ];
            }
            fclose($handle);
        }

        foreach($csv as $item) {
            $artist = $artistRepository->findOneBy(['name' => $item['artistName']]);
            $country = $countryRepository->findOneBy(['name' => $item['artistCountry']]);
            $album = $albumRepository->findOneBy(['title' => $item['albumTitle']]);
            $song = $songRepository->findOneBy(['title' => $item['songTitle']]);
            $genre = $genreRepository->findOneBy(['libelle' => $item['songGenre']]);
            $formatExp = explode(",", $item['albumFormat']);
            
            if(!$country) { //le pays n'existe pas donc on l'ajoute
                $country = new Country();
                $country->setName($item['artistCountry']);
                $entityManager->persist($country);
                $entityManager->flush();
            }
            if(!$album) { //l'album n'existe pas donc on l'ajoute
                $album = new Album();
                $album->setTitle($item['albumTitle']);
                $album->setYear($item['albumYear']);
                $album->setCreatedAt(new \DateTimeImmutable());
                $album->setUpdateAt(new \DateTimeImmutable());
                $albumMedia = $mediaRepository->find($item['albumMedia']);
                $album->setMedia($albumMedia);
                $entityManager->persist($album);
                $entityManager->flush();
            }
            if(!$genre) { //le genre n'existe pas donc on l'ajoute
                $genre = new Genre();
                $genre->setLibelle($item['songGenre']);
                $entityManager->persist($genre);
                $entityManager->flush();
            }
            if(!$song) { //la chanson n'existe pas donc on l'ajoute
                $song = new Song();
                $song->setTitle($item['songTitle']);
                $song->setDescription($item['songDescription']);
                $song->setDuration($item['songDuration']);
                $song->setGenre($genre);
                $entityManager->persist($song);
                $entityManager->flush();
            }
            if(!$artist) { //si l'artiste n'existe pas on le créer
                $artist = new Artist();
                $artist->setName($item['artistName']);
                $artist->setDescription($item['artistDescription']);
                $artist->setBirthDate(DateTime::createFromFormat('Y-m-d', $item['artistBirthDate']));
                if($item['artistDeathDate'] === "0000-00-00" || $item['artistDeathDate'] === "") {
                    $deathDate = null;
                } else {
                    $deathDate = DateTime::createFromFormat('Y-m-d', $item['artistDeathDate']);
                }
                $artist->setDeathDate($deathDate);
                $artistMedia = $mediaRepository->find($item['artistMedia']);
                $artist->setMedia($artistMedia);
                $artist->setCountry($country);
                $entityManager->persist($artist);
                $entityManager->flush();
            }
            foreach($formatExp as $formatItem) { //on parcours la liste des formats
                $format = $formatRepository->findOneBy(['libelle' => $formatItem]);
                if(!$format) { //le format n'existe pas donc on l'ajoute
                    $format = new Format();
                    $format->setLibelle($formatItem);
                    $entityManager->persist($format);
                    $entityManager->flush();
                }
                if ($album && $format) { //on remplit la table intermédiaire album_format
                    $album->addFormat($format);
                    $entityManager->persist($album);
                    $entityManager->flush();
                }
            }
            if ($artist && $album) { //on remplit la table intermédiaire artist_album
                $artist->addAlbum($album);
                $entityManager->persist($artist);
                $entityManager->flush();
            }
            if ($artist && $song) { //on remplit la table intermédiaire artist_song
                $artist->addSong($song);
                $entityManager->persist($artist);
                $entityManager->flush();
            }
            if ($album && $song) {  //on remplit la table intermédiaire album_song
                $album->addSong($song);
                $entityManager->persist($album);
                $entityManager->flush();
            }
        }
        // $this->addFlash('Fichier CSV téléchargé et traité avec succès.');
        return $this->redirectToRoute('index');
    }

}
