<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use App\Entity\Artist;
use App\Entity\Country;
use App\Entity\Album;
use App\Entity\Genre;
use App\Entity\Song;
use App\Entity\Format;
use App\Entity\Media;
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

    #[Route('/download_csv_collection/{filename}/{idUser}', name: 'download_csv_collection', methods: ['GET'])]
    public function downloadCSVCollection(string $filename, int $idUser, UserRepository $userRepository, UserAlbumFormatRepository $userAlbumFormatRepository): Response
    {
        $user = $userRepository->find($idUser);
        $type = "Collection";
        $userAlbumFormats = $userAlbumFormatRepository->findByUserCollectionType($user, $type);

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

    #[Route('/download_docx_collection/{filename}/{idUser}', name: 'download_docx_collection', methods: ['GET'])]
    public function downloadDOCXCollection(string $filename, int $idUser, UserRepository $userRepository, UserAlbumFormatRepository $userAlbumFormatRepository): Response
    {
        $user = $userRepository->find($idUser);
        $type = "Collection";
        $userAlbumFormats = $userAlbumFormatRepository->findByUserCollectionType($user, $type);

        //Organize the data by format, artist, and albums
        $albumsByFormat = [];

        foreach ($userAlbumFormats as $userAlbumFormat) {
            $format = $userAlbumFormat->getFormat()->getLibelle();
            $artistsAlbum = $userAlbumFormat->getAlbum()->getArtists();
            $albumTitle = $userAlbumFormat->getAlbum()->getTitle();
            $albumYear = $userAlbumFormat->getAlbum()->getYear();

            foreach ($artistsAlbum as $artist) {
                $artistName = $artist->getName();
                $albumsByFormat[$format][$artistName][] = [
                    'title' => $albumTitle,
                    'year' => $albumYear
                ];
            }
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        foreach ($albumsByFormat as $format => $artists) {
            $section->addTitle($format, 2);
            foreach ($artists as $artist => $albums) {
                $section->addText($artist . ':');
                $listStyle = ['indent' => 1];
                foreach ($albums as $album) {
                    $section->addListItem($album['title'] . ' (' . $album['year'] . ')', 0, null, $listStyle);
                }
            }
        }

        //Generate the DOCX file
        $tempFile = tempnam(sys_get_temp_dir(), 'phpword');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        //Create the streamed response for download
        $response = new StreamedResponse(function () use ($tempFile) {
            readfile($tempFile);
            unlink($tempFile); //Delete the temporary file after reading
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        ));

        return $response;
    }

    #[Route('/download_pdf_collection/{filename}/{idUser}', name: 'download_pdf_collection', methods: ['GET'])]
    public function downloadPDFCollection(string $filename, int $idUser, UserRepository $userRepository, UserAlbumFormatRepository $userAlbumFormatRepository, ): Response
    {
        $user = $userRepository->find($idUser);
        $type = "Collection";
        $userAlbumFormats = $userAlbumFormatRepository->findByUserCollectionType($user, $type);
        $dompdf = new Dompdf();
        $html = '';

        $albumsByFormat = [];
        foreach ($userAlbumFormats as $userAlbumFormat) {
            $currentFormat = $userAlbumFormat->getFormat()->getLibelle();

            if (!isset($albumsByFormat[$currentFormat])) {
                $albumsByFormat[$currentFormat] = [];
            }

            $artists = "";
            $artistsAlbum = $userAlbumFormat->getAlbum()->getArtists();
            foreach ($artistsAlbum as $artist) {
                $artists .= $artist->getName() . ', ';
            }
            $artists = rtrim($artists, ', ');

            $albumsByFormat[$currentFormat][$artists][] = [
                'title' => $userAlbumFormat->getAlbum()->getTitle(),
                'year' => $userAlbumFormat->getAlbum()->getYear(),
            ];
        }

        foreach ($albumsByFormat as $format => $artists) {
            $html .= '<h2>'.$format.'</h2>';
            foreach ($artists as $artist => $albums) {
                $html .= '<p>'.$artist.':</p>';
                $html .= '<ul>';
                foreach ($albums as $album) {
                    $html .= '<li><p style="margin-left: 20px;">'.$album['title'].'('.$album['year'].')</p></li>';
                }
                $html .= '</ul>';
            }
        }

        $dompdf->loadHtml($html);
        $dompdf->render();
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"'
        ]);
    }

    #[Route('/download_csv_search/{filename}/{idUser}', name: 'download_csv_search', methods: ['GET'])]
    public function downloadCSVSearch(string $filename, int $idUser, UserRepository $userRepository, UserAlbumFormatRepository $userAlbumFormatRepository): Response
    {
        $user = $userRepository->find($idUser);
        $type = "Search";
        $userAlbumFormats = $userAlbumFormatRepository->findByUserCollectionType($user, $type);

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

    #[Route('/download_pdf_search/{filename}/{idUser}', name: 'download_pdf_search', methods: ['GET'])]
    public function downloadPDFSearch(string $filename, int $idUser, UserRepository $userRepository, UserAlbumFormatRepository $userAlbumFormatRepository, ): Response
    {
        $user = $userRepository->find($idUser);
        $type = "Search";
        $userAlbumFormats = $userAlbumFormatRepository->findByUserCollectionType($user, $type);
        $dompdf = new Dompdf();
        $html = '';

        $albumsByFormat = [];
        foreach ($userAlbumFormats as $userAlbumFormat) {
            $currentFormat = $userAlbumFormat->getFormat()->getLibelle();

            if (!isset($albumsByFormat[$currentFormat])) {
                $albumsByFormat[$currentFormat] = [];
            }

            $artists = "";
            $artistsAlbum = $userAlbumFormat->getAlbum()->getArtists();
            foreach ($artistsAlbum as $artist) {
                $artists .= $artist->getName() . ', ';
            }
            $artists = rtrim($artists, ', ');

            $albumsByFormat[$currentFormat][$artists][] = [
                'title' => $userAlbumFormat->getAlbum()->getTitle(),
                'year' => $userAlbumFormat->getAlbum()->getYear(),
            ];
        }

        foreach ($albumsByFormat as $format => $artists) {
            $html .= '<h2>'.$format.'</h2>';
            foreach ($artists as $artist => $albums) {
                $html .= '<p>'.$artist.':</p>';
                $html .= '<ul>';
                foreach ($albums as $album) {
                    $html .= '<li><p style="margin-left: 20px;">'.$album['title'].'('.$album['year'].')</p></li>';
                }
                $html .= '</ul>';
            }
        }

        $dompdf->loadHtml($html);
        $dompdf->render();
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"'
        ]);
    }

    #[Route('/download_docx_search/{filename}/{idUser}', name: 'download_docx_search', methods: ['GET'])]
    public function downloadDOCXSearch(string $filename, int $idUser, UserRepository $userRepository, UserAlbumFormatRepository $userAlbumFormatRepository): Response
    {
        $user = $userRepository->find($idUser);
        $type = "Search";
        $userAlbumFormats = $userAlbumFormatRepository->findByUserCollectionType($user, $type);

        //Organize the data by format, artist, and albums
        $albumsByFormat = [];

        foreach ($userAlbumFormats as $userAlbumFormat) {
            $format = $userAlbumFormat->getFormat()->getLibelle();
            $artistsAlbum = $userAlbumFormat->getAlbum()->getArtists();
            $albumTitle = $userAlbumFormat->getAlbum()->getTitle();
            $albumYear = $userAlbumFormat->getAlbum()->getYear();

            foreach ($artistsAlbum as $artist) {
                $artistName = $artist->getName();
                $albumsByFormat[$format][$artistName][] = [
                    'title' => $albumTitle,
                    'year' => $albumYear
                ];
            }
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        foreach ($albumsByFormat as $format => $artists) {
            $section->addTitle($format, 2);
            foreach ($artists as $artist => $albums) {
                $section->addText($artist . ':');
                $listStyle = ['indent' => 1];
                foreach ($albums as $album) {
                    $section->addListItem($album['title'] . ' (' . $album['year'] . ')', 0, null, $listStyle);
                }
            }
        }

        //Generate the DOCX file
        $tempFile = tempnam(sys_get_temp_dir(), 'phpword');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        //Create the streamed response for download
        $response = new StreamedResponse(function () use ($tempFile) {
            readfile($tempFile);
            unlink($tempFile); //Delete the temporary file after reading
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        ));

        return $response;
    }

    #[Route('/upload_csv', name: 'upload_csv', methods: ['GET', 'POST'])]
    public function upload(AuthorizationCheckerInterface $authorization, Request $request, ArtistRepository $artistRepository, MediaRepository $mediaRepository, GenreRepository $genreRepository, SongRepository $songRepository, CountryRepository $countryRepository, AlbumRepository $albumRepository, FormatRepository $formatRepository, EntityManagerInterface $entityManager): Response
    {
        $route = $request->query->get('route');
        $idUser = $request->query->get('idUser');
        if ($authorization->isGranted('ROLE_ADMIN')) {
            $valid = true;
        } else {
            $valid = false;
        }
        $param = [];
        if($idUser) { //If there is a parameter like an id (for the user page)
            $param = ['idUser' => $idUser];
        }  

        //Retrieve the uploaded file
        $csvFile = $request->files->get('csv_file');

        //Verify if it is indeed a CSV file
        if (!$csvFile) {
            throw $this->createNotFoundException('Aucun fichier uploadé.');
        }

        // Vérifier si c'est bien un fichier CSV
        if ($csvFile->getClientOriginalExtension() !== 'csv') {
            throw $this->createNotFoundException('Le fichier n\'est pas un fichier CSV.');
        }

        //Iterate through the rows of the CSV file
        $csv = [];
        if (($handle = fopen($csvFile->getPathname(), "r")) !== FALSE) {
            fgetcsv($handle, 1000, ";");
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $data = array_map('utf8_encode', $data);
                $artistName = trim($data[0]);
                $artistCountry = trim($data[1]);
                $artistDescription = trim($data[2]);
                $artistBirthDate = trim($data[3]);
                $artistDeathDate = trim($data[4]);
                $artistMedia = trim($data[5]);
                $albumTitle = trim($data[6]);
                $albumYear = (int) trim($data[7]);
                $albumFormat = trim($data[8]);
                $albumMedia = trim($data[9]);
                $songGenre = trim($data[10]);
                $songTitle = trim($data[11]);
                if(isset($data[12])) {
                    $songDescription = trim($data[12]);
                } else {
                    $songDescription = "";
                }
                if(isset($data[13])) {
                    $songDuration = (int) trim($data[13]);
                } else {
                    $songDuration = 0;
                }    
                $csv[] = [
                    "artistName" => $artistName,
                    "artistCountry" => $artistCountry,
                    "artistDescription" => $artistDescription,
                    "artistBirthDate" => $artistBirthDate,
                    "artistDeathDate" => $artistDeathDate,
                    "albumTitle" => $albumTitle,
                    "albumYear" => $albumYear,
                    "albumMedia" => $albumMedia,
                    "albumFormat" => $albumFormat,
                    "songGenre" => $songGenre,
                    "songTitle" => $songTitle,
                    "songDescription" => $songDescription,
                    "songDuration" => $songDuration,
                    "artistMedia" => $artistMedia,
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
            $mediaArtist = $mediaRepository->findOneBy(['alt' => $item['artistName']]);
            $mediaAlbum = $mediaRepository->findOneBy(['alt' => $item['albumTitle']]);
            $formatExp = explode(",", $item['albumFormat']);
            
            if(!empty($item['artistMedia'])) { // if artist media is not empty
                $img = '../public/build/images/'.$item['artistName'];
                $artistMediaName = $item['artistName'];
                $content = @file_get_contents($item['artistMedia']);
                if ($content === false) {
                    echo "Erreur lors du téléchargement de l'image depuis l'URL.";
                    $this->addFlash('notice', "Erreur lors du téléchargement de l'image depuis l'URL.");
                } else {
                    $extension = pathinfo($item['artistMedia'], PATHINFO_EXTENSION);
                    $img .= '.' . $extension;
                    $artistMediaName .= '.' . $extension;
                    file_put_contents($img, $content);
                } 
            } else {
                $this->addFlash('notice', 'Le média pour l\'artiste est obligatoire');

                return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
            }

            if(!empty($item['albumMedia'])) { // if album media is not empty
                $img = '../public/build/images/'.$item['albumTitle'];
                $albumMediaName = $item['albumTitle'];
                $content = @file_get_contents($item['albumMedia']);
                if ($content === false) {
                    $this->addFlash('notice', "Erreur lors du téléchargement de l'image depuis l'URL.");
                } else {
                    $extension = pathinfo($item['albumMedia'], PATHINFO_EXTENSION);
                    $img .= '.' . $extension;
                    $albumMediaName .= '.' . $extension;
                    file_put_contents($img, $content);
                }
            }

            if(!$mediaArtist) { //The media for this artist does not exist, so we add it
                $mediaArtist = new Media();
                $mediaArtist->setUrl($artistMediaName);
                $mediaArtist->setAlt($item['artistName']);
                $mediaArtist->setUrlSource($item['artistMedia']);
                $entityManager->persist($mediaArtist);
                $entityManager->flush();
            }
            if(!$mediaAlbum) { //The media for this album does not exist, so we add it
                $mediaAlbum = new Media();
                $mediaAlbum->setUrl($albumMediaName);
                $mediaAlbum->setAlt($item['albumTitle']);
                $mediaAlbum->setUrlSource($item['albumMedia']);
                $entityManager->persist($mediaAlbum);
                $entityManager->flush();
            }
            if(!$country) { //The country does not exist, so we add it
                $country = new Country();
                $country->setName($item['artistCountry']);
                $entityManager->persist($country);
                $entityManager->flush();
            }
            if(!$album && $item['albumTitle']) { //The album does not exist, so we add it
                $album = new Album();
                $album->setTitle($item['albumTitle']);
                $album->setYear($item['albumYear']);
                $album->setCreatedAt(new \DateTimeImmutable());
                $album->setUpdateAt(new \DateTimeImmutable());
                $album->setMedia($mediaAlbum);
                $album->setValid($valid);
                $entityManager->persist($album);
                $entityManager->flush();
            }
            if(!$genre) { //The genre does not exist, so we add it
                $genre = new Genre();
                $genre->setLibelle($item['songGenre']);
                $entityManager->persist($genre);
                $entityManager->flush();
            }
            if(!$song) { //The song does not exist, so we add it
                $song = new Song();
                $song->setTitle($item['songTitle']);
                $song->setDescription($item['songDescription']);
                $song->setDuration($item['songDuration']);
                $song->setGenre($genre);
                $song->setValid($valid);
                $entityManager->persist($song);
                $entityManager->flush();
            }
            if(!$artist) { //If the artist does not exist, we create it
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
                $artist->setMedia($mediaArtist);
                $artist->setCountry($country);
                $artist->setValid($valid);
                $entityManager->persist($artist);
                $entityManager->flush();
            }
            foreach($formatExp as $formatItem) { //We iterate through the list of formats
                $format = $formatRepository->findOneBy(['libelle' => $formatItem]);
                if(!$format) { //The format does not exist, so we add it
                    $format = new Format();
                    $format->setLibelle($formatItem);
                    $entityManager->persist($format);
                    $entityManager->flush();
                }
                if ($album && $format) { //We populate the intermediate table album_format
                    $album->addFormat($format);
                    $entityManager->persist($album);
                    $entityManager->flush();
                }
            }
            if ($artist && $album) { //We populate the intermediate table artist_album
                $artist->addAlbum($album);
                $entityManager->persist($artist);
                $entityManager->flush();
            }
            if ($artist && $song) { //We populate the intermediate table artist_song
                $artist->addSong($song);
                $entityManager->persist($artist);
                $entityManager->flush();
            }
            if ($album && $song) {  //We populate the intermediate table album_song
                $album->addSong($song);
                $entityManager->persist($album);
                $entityManager->flush();
            }
        }
        $this->addFlash('notice', "Le fichier a bien été importé");

        return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
    }

}
