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
        if($idUser) { //s'il y a un paramètre comme un id (pour la page du user)
            $param = ['idUser' => $idUser];
        } 

        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            //if user is admin, valid is true, else valid is false
            $artist->setValid($valid);

            $media =  $form->get('mediabis')->getData();
            $artistName =  $artist->getName();
            if(!empty($media)) { // if album media is not empty
                $img = '../assets/imgs/'.$artistName;
                $content = @file_get_contents($media);
                if ($content === false) {
                    $this->addFlash('notice', "Erreur lors du téléchargement de l'image depuis l'URL.");

                    return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
                } else {
                    $extension = pathinfo($media, PATHINFO_EXTENSION);
                    $img .= '.'.$extension;
                    $artistNameImg = $artistName.'.'.$extension;
                    file_put_contents($img, $content);
                }
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
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

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
            $artist->getAlbums()->initialize();
            dd($artist->getAlbums());
            //méthode normale symfony
            // $entityManager->remove($artist);
            // $entityManager->flush();
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
