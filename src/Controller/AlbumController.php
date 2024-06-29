<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Media;
use App\Form\AlbumType;
use App\Entity\UserAlbumFormat;
use App\Repository\AlbumRepository;
use App\Repository\UserRepository;
use App\Repository\SongRepository;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Repository\FormatRepository;
use App\Repository\UserAlbumFormatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/albums')]
class AlbumController extends AbstractController
{
    #[Route('/', name: 'albums', methods: ['GET'])]
    public function displayAll(AlbumRepository $albumRepository): Response {
        return $this->render("albums/albums-list.html.twig", [
            'albums' => $albumRepository->findByValid(),
        ]);
    }

    #[Route('/new', name: 'album_new', methods: ['GET', 'POST'])]
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

        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album, [
            'is_edit' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //if user is admin, valid is true, else valid is false
            $album->setValid($valid);
            $album->setCreatedAt(new \DateTimeImmutable());
            $album->setUpdateAt(new \DateTimeImmutable());

            foreach ($album->getArtists() as $artist) {
                $artist->addAlbum($album);
            }

            foreach ($album->getFormats() as $format) {
                $album->addFormat($format);
            }

            $urlMedia =  $form->get('mediaUrl')->getData();
            $uploadMedia =  $form->get('mediaUpload')->getData();
            $albumTitle =  $album->getTitle();
            if(!empty($urlMedia)) { // if album media is not empty
                $img = '../public/build/images/'.$albumTitle;
                $content = @file_get_contents($urlMedia);
                if ($content === false) {
                    $this->addFlash('notice', "Erreur lors du téléchargement de l'image depuis l'URL.");

                    return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
                } else {
                    $extension = pathinfo($urlMedia, PATHINFO_EXTENSION);
                    $img .= '.'.$extension;
                    $albumTitleImg = $albumTitle.'.'.$extension;
                    file_put_contents($img, $content);
                }
                $media = $urlMedia;
            } else if(!empty($uploadMedia)) { // if url media is not empty
                $albumTitleImg = $albumTitle.'.'.$uploadMedia->guessExtension();
                try {
                    $uploadMedia->move(
                        $this->getParameter('media_directory'),
                        $albumTitleImg
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
            $mediaAlbum = new Media();
            $mediaAlbum->setUrl($albumTitleImg);
            $mediaAlbum->setAlt($albumTitle);
            $mediaAlbum->setUrlSource($media);
            $album->setMedia($mediaAlbum);

            $entityManager->persist($mediaAlbum);         
            $entityManager->persist($album);
            $entityManager->flush();

            $this->addFlash('notice', "L'album est bien ajouté");

            return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
        }

        return $this->render('albums/new.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/{idAlbum}', name: 'album', methods: ['GET'])]
    public function displayOne(SongRepository $songRepository, AlbumRepository $albumRepository, int $idAlbum): Response {
        $album = $albumRepository->find($idAlbum);
        if (!$album) {
            throw $this->createNotFoundException('Album not found');
        }
        return $this->render("albums/album-show.html.twig", [
            'album' => $album, 
            'songs' => $songRepository->findByAlbum($album)
        ]);
    }

    #[Route('/{id}/edit', name: 'album_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AlbumType::class, $album, [
            'is_edit' => true,
        ]);
        $form->handleRequest($request);

        //refresh artists of this album
        $entityManager->refresh($album);
        foreach ($album->getArtists() as $artist) {
            $entityManager->refresh($artist);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            //new media is not empty so we modify old media
            $urlMedia =  $form->get('mediaUrl')->getData();
            $uploadMedia =  $form->get('mediaUpload')->getData();
            $albumTitle =  $album->getTitle();
            $oldMedia = $album->getMedia();
            if(!empty($urlMedia)) { // if album media is not empty
                $img = '../public/build/images/'.$albumTitle;
                $content = @file_get_contents($urlMedia);
                //remove old picture from assets
                unlink('../public/build/images/'.$oldMedia->getUrl()); 
                if ($content === false) {
                    $this->addFlash('notice', "Erreur lors du téléchargement de l'image depuis l'URL.");

                    return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
                } else {
                    $extension = pathinfo($urlMedia, PATHINFO_EXTENSION);
                    $img .= '.'.$extension;
                    $albumTitleImg = $albumTitle.'.'.$extension;
                    file_put_contents($img, $content);
                }
                $media = $urlMedia;
            } else if(!empty($uploadMedia)) { // if url media is not empty
                $albumTitleImg = $albumTitle.'.'.$uploadMedia->guessExtension();
                //remove old picture from assets
                unlink('../public/build/images/'.$oldMedia->getUrl()); 
                try {
                    $uploadMedia->move(
                        $this->getParameter('media_directory'),
                        $albumTitleImg
                    );      
                } catch(FileException $e) {
                    $this->addFlash('notice', "Erreur lors de l\'upload du fichier".e->getMessage());

                    return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
                }
                $media = "Upload";
            }
            if(!empty($urlMedia) || !empty($uploadMedia)) {
                //update media for artist
                $oldMedia->setUrl($albumTitleImg);
                $oldMedia->setAlt($albumTitle);
                $oldMedia->setUrlSource($media);
            }

            $selectedArtists = $form->get('artists')->getData();
            foreach ($album->getArtists() as $artist) { //delete artists non selected
                if (!$selectedArtists->contains($artist)) {
                    $album->removeArtist($artist);
                }
            }         
            foreach ($selectedArtists as $artist) { //add new artists
                if (!$album->getArtists()->contains($artist)) {
                    $album->addArtist($artist);
                }
            }

            $entityManager->flush();

            $this->addFlash('notice', "L'album a bien été modifié");

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('albums/edit.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'album_delete', methods: ['POST'])]
    public function delete(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {
            foreach ($album->getSongs() as $song) { // Remove relations with songs
                $album->removeSong($song);
            }

            foreach ($album->getFormats() as $format) { // Remove relations between album and format
                $album->removeFormat($format);
            }

            //remove picture from assets
            unlink('../assets/imgs/'.$album->getMedia()->getUrl());
            $entityManager->remove($album->getMedia()); //remove media

            $entityManager->remove($album);
            $entityManager->flush();

            $this->addFlash('notice', "L'album a bien été supprimé");
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/valid', name: 'album_valid', methods: ['POST'])]
    public function valid(Request $request, Album $album, EntityManagerInterface $entityManager, AlbumRepository $albumRepository): Response
    {
        if ($this->isCsrfTokenValid('valid'.$album->getId(), $request->request->get('_token'))) {
            $album = $albumRepository->find($album->getId());
            $album->setValid(1);
            $entityManager->persist($album);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/add_collection/{idAlbum}/{idUser}/{idFormat}', name: 'add_collection', methods: ['GET'])]
    public function addCollection(int $idAlbum, int $idUser, int $idFormat, AlbumRepository $albumRepository, UserRepository $userRepository, UserAlbumFormatRepository $userAlbumFormatRepository, FormatRepository $formatRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $returnUrl = $request->query->get('returnUrl');
        $parametre = $request->query->get('parametre');
        $type = "Collection";
        $param = [];
        if($parametre) { //If there is a parameter like an id (for the artist's page)
            $param = ['idArtist' => $parametre];
        }
        $format = $formatRepository->find($idFormat);
        $album = $albumRepository->find($idAlbum);
        $user = $userRepository->find($idUser);
        $userAlbumFormatsRepo = $userAlbumFormatRepository->findByUserAlbumFormatType($user, $album, $format, $type);
        if($userAlbumFormatsRepo) { //the user as already this album
            foreach ($userAlbumFormatsRepo as $userAlbumFormat) {
                $entityManager->remove($userAlbumFormat);
                $entityManager->flush();
            }
        } else {
            $userAlbumFormat = new UserAlbumFormat();
            $userAlbumFormat->setUser($user);
            $userAlbumFormat->setAlbum($album);
            $userAlbumFormat->setFormat($format);
            $userAlbumFormat->setType($type);
            $entityManager->persist($userAlbumFormat);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute($returnUrl, $param);
    }

    #[Route('/add_search/{idAlbum}/{idUser}/{idFormat}', name: 'add_search', methods: ['GET'])]
    public function addSearch(int $idAlbum, int $idUser, int $idFormat, AlbumRepository $albumRepository, UserRepository $userRepository, UserAlbumFormatRepository $userAlbumFormatRepository, FormatRepository $formatRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $returnUrl = $request->query->get('returnUrl');
        $parametre = $request->query->get('parametre');
        $type = "Search";
        $param = [];
        if($parametre) { //If there is a parameter like an id (for the artist's page)
            $param = ['idArtist' => $parametre];
        }
        $format = $formatRepository->find($idFormat);
        $album = $albumRepository->find($idAlbum);
        $user = $userRepository->find($idUser);
        $userAlbumFormatsRepo = $userAlbumFormatRepository->findByUserAlbumFormatType($user, $album, $format, $type);
        if($userAlbumFormatsRepo) { //the user as already this album
            foreach ($userAlbumFormatsRepo as $userAlbumFormat) {
                $entityManager->remove($userAlbumFormat);
                $entityManager->flush();
            }
        } else {
            $userAlbumFormat = new UserAlbumFormat();
            $userAlbumFormat->setUser($user);
            $userAlbumFormat->setAlbum($album);
            $userAlbumFormat->setFormat($format);
            $userAlbumFormat->setType($type);
            $entityManager->persist($userAlbumFormat);
            $entityManager->flush();
        }
                 
        return $this->redirectToRoute($returnUrl, $param);
    }
}
