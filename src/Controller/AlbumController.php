<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
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

    // #[Route('/{idArtist}', name: 'artist', methods: ['GET'])]
    // public function displayOne(ArtistRepository $artistRepository, AlbumRepository $albumRepository, int $idArtist): Response {
    //     $artist = $artistRepository->find($idArtist);
    //     return $this->render("artists/artist-show.html.twig", [
    //         'artist' => $artist, 
    //         'albums' => $albumRepository->findByArtist($artist)
    //     ]);
    // }



    // #[Route('/', name: 'app_album_index', methods: ['GET'])]
    // public function index(AlbumRepository $albumRepository): Response
    // {
    //     return $this->render('album/index.html.twig', [
    //         'albums' => $albumRepository->findAll(),
    //     ]);
    // }

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

    // #[Route('/{id}', name: 'app_album_show', methods: ['GET'])]
    // public function show(Album $album): Response
    // {
    //     return $this->render('album/show.html.twig', [
    //         'album' => $album,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'app_album_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(AlbumType::class, $album);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('album/edit.html.twig', [
    //         'album' => $album,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_album_delete', methods: ['POST'])]
    // public function delete(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($album);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
    // }
}
