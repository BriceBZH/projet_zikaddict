<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistType;
use App\Entity\Media;
use App\Repository\ArtistRepository;
use App\Repository\AlbumRepository;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/artists')]
class ArtistController extends AbstractController
{
    #[Route('/', name: 'artists', methods: ['GET'])]
    public function displayAll(ArtistRepository $artistRepository): Response {
        return $this->render("artists/artists-list.html.twig", [
            'artists' => $artistRepository->findByValid(),
        ]);
    }

    #[Route('/new', name: 'artist_new', methods: ['GET', 'POST'])]
    public function new(AuthorizationCheckerInterface $authorization, Request $request, EntityManagerInterface $entityManager): Response
    {
        $route = $request->query->get('route');
        $idUser = $request->query->get('idUser');
        if ($authorization->isGranted('ROLE_ADMIN')) {
            $valid = true;
        } else {
            $valid = false;
        }
        $param = [];
        if($idUser) { //If there is a parameter like an id (for the user's page)
            $param = ['idUser' => $idUser];
        } 

        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist, [
            'is_edit' => false,
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            //if user is admin, valid is true, else valid is false
            $artist->setValid($valid);

            $urlMedia =  $form->get('mediaUrl')->getData();
            $uploadMedia =  $form->get('mediaUpload')->getData();
            $artistName =  $artist->getName();
            if(!empty($urlMedia)) { // if url media is not empty
                $img = '../public/build/images/'.$artistName;
                $content = @file_get_contents($urlMedia);
                if ($content === false) {
                    $this->addFlash('notice', "Erreur lors du téléchargement de l'image depuis l'URL.");

                    return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
                } else {
                    $extension = pathinfo($urlMedia, PATHINFO_EXTENSION);
                    $img .= '.'.$extension;
                    $artistNameImg = $artistName.'.'.$extension;
                    file_put_contents($img, $content);
                }
                $media = $urlMedia;
            } else if(!empty($uploadMedia)) { // if upload media is not empty
                $artistNameImg = $artistName.'.'.$uploadMedia->guessExtension();
                try {
                    $uploadMedia->move(
                        $this->getParameter('media_directory'),
                        $artistNameImg
                    );
                    $media = "Upload";
                } catch(FileException $e) {
                    $this->addFlash('notice', "Erreur lors de l\'upload du fichier".e->getMessage());

                    return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
                } 
            } else {
                $this->addFlash('notice', "Erreur aucun media ajouté");

                return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
            }


            //add media for artist
            $mediaArtist = new Media();
            $mediaArtist->setUrl($artistNameImg);
            $mediaArtist->setAlt($artistName);
            $mediaArtist->setUrlSource($media);
            $artist->setMedia($mediaArtist);

            $entityManager->persist($mediaArtist);         
            $entityManager->persist($artist);
            $entityManager->flush();

            $this->addFlash('notice', "L'artiste est bien ajouté");

            return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
        }

        return $this->render('artists/new.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[Route('/{idArtist}', name: 'artist', methods: ['GET'])]
    public function displayOne(ArtistRepository $artistRepository, AlbumRepository $albumRepository, int $idArtist): Response {
        $artist = $artistRepository->find($idArtist);
        return $this->render("artists/artist-show.html.twig", [
            'artist' => $artist, 
            'albums' => $albumRepository->findByArtist($artist)
        ]);
    }

    

    #[Route('/{id}/edit', name: 'artist_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Artist $artist, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtistType::class, $artist, [
            'is_edit' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //new media is not empty so we modify old media
            $urlMedia =  $form->get('mediaUrl')->getData();
            $uploadMedia =  $form->get('mediaUpload')->getData();
            $artistName =  $artist->getName();
            $oldMedia = $artist->getMedia();
            if(!empty($urlMedia)) { // if url media is not empty
                $img = '../public/build/images/'.$artistName;
                $content = @file_get_contents($urlMedia);
                //remove old picture from assets
                unlink('../public/build/images/'.$oldMedia->getUrl());
                if ($content === false) {
                    $this->addFlash('notice', "Erreur lors du téléchargement de l'image depuis l'URL.");

                    return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
                } else {
                    $extension = pathinfo($urlMedia, PATHINFO_EXTENSION);
                    $img .= '.'.$extension;
                    $artistNameImg = $artistName.'.'.$extension;
                    file_put_contents($img, $content);
                }
                $media = $urlMedia;
            } else if(!empty($uploadMedia)) { // if upload media is not empty
                $artistNameImg = $artistName.'.'.$uploadMedia->guessExtension();
                //remove old picture from assets
                unlink('../public/build/images/'.$oldMedia->getUrl());
                try {
                    $uploadMedia->move(
                        $this->getParameter('media_directory'),
                        $artistNameImg
                    );
                } catch(FileException $e) {
                    $this->addFlash('notice', "Erreur lors de l\'upload du fichier".e->getMessage());

                    return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
                } 
                $media = "Upload";
            }
            if(!empty($urlMedia) || !empty($uploadMedia)) {
                //update media for artist
                $oldMedia->setUrl($artistNameImg);
                $oldMedia->setAlt($artistName);
                $oldMedia->setUrlSource($media);
            }
            $entityManager->flush();

            $this->addFlash('notice', "L'artiste a bien été modifié");

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artists/edit.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'artist_delete', methods: ['POST'])]
    public function delete(Request $request, Artist $artist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
            foreach ($artist->getAlbums() as $album) { // Remove relations with albums
                $artist->removeAlbum($album);

                foreach ($album->getSongs() as $albumSong) { // Remove relations between album and song
                    $album->removeSong($albumSong);
                    $entityManager->remove($albumSong); 
                }

                foreach ($album->getFormats() as $albumFormat) { // Remove relations between album and format
                    $album->removeFormat($albumFormat);
                }

                //remove picture from assets
                unlink('../assets/imgs/'.$album->getMedia()->getUrl());
                $entityManager->remove($album->getMedia()); //remove media
                $entityManager->remove($album); // Remove the album
            }

            foreach ($artist->getSongs() as $song) { // Remove relations with songs
                $artist->removeSong($song);
            }
            //remove picture from assets
            unlink('../assets/imgs/'.$artist->getMedia()->getUrl());
            $entityManager->remove($artist->getMedia()); //remove media
            $entityManager->remove($artist);
            $entityManager->flush();

            $this->addFlash('notice', "L'artiste a bien été supprimé");
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/valid', name: 'artist_valid', methods: ['POST'])]
    public function valid(Request $request, Artist $artist, EntityManagerInterface $entityManager, ArtistRepository $artistRepository): Response
    {
        if ($this->isCsrfTokenValid('valid'.$artist->getId(), $request->request->get('_token'))) {
            $artist = $artistRepository->find($artist->getId());
            $artist->setValid(1);
            $entityManager->persist($artist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }
}
