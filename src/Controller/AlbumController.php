<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use App\Repository\UserRepository;
use App\Repository\SongRepository;
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
            'albums' => $albumRepository->findAll(),
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

    // #[Route('/new', name: 'app_album_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $album = new Album();
    //     $form = $this->createForm(AlbumType::class, $album);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($album);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('album/new.html.twig', [
    //         'album' => $album,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'album_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('albums/edit.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'album_delete', methods: ['POST'])]
    public function delete(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {
            $entityManager->remove($album);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/add_collection/{idAlbum}/{idUser}', name: 'add_collection', methods: ['GET'])]
    public function addCollection(int $idAlbum, int $idUser, AlbumRepository $albumRepository, UserRepository $userRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $returnUrl = $request->query->get('returnUrl');
        $parametre = $request->query->get('parametre');
        $param = [];
        if($parametre) { //s'il y a un paramètre comme un id (pour la page de l'artiste)
            $param = ['idArtist' => $parametre];
        }
        $album = $albumRepository->find($idAlbum);
        $user = $userRepository->find($idUser);
        if ($album && $user) {  //on remplit la table intermédiaire user_album
            $user->addAlbum($album);
            $entityManager->persist($user);
            $entityManager->flush();
        }    
        return $this->redirectToRoute($returnUrl, $param);
    }
}
