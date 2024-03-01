<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/artist')]
class ArtistController extends AbstractController
{
    #[Route('/', name: 'app_artist_index', methods: ['GET'])]
    public function displayAll(ArtistRepository $artistRepository): Response {
        return $this->render("artists/artists-list.html.twig", [
            'artists' => $artistRepository->findAll(),
        ]);
    }

    #[Route('/{idArtist}', name: 'app_artist_indexd', methods: ['GET'])]
    public function displayOne(ArtistRepository $artistRepository, AlbumRepository $albumRepository, int $idArtist): Response {
        return $this->render("artists/artist-show.html.twig", [
            'artist' => $artistRepository->findById($idArtist), 
            'albums' => $albumRepository->findByArtist($idArtist)
        ]);
    }
    // #[Route('/', name: 'app_artist_index', methods: ['GET'])]
    // public function index(ArtistRepository $artistRepository): Response
    // {
    //     return $this->render('artist/index.html.twig', [
    //         'artists' => $artistRepository->findAll(),
    //     ]);
    // }

    // #[Route('/new', name: 'app_artist_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $artist = new Artist();
    //     $form = $this->createForm(ArtistType::class, $artist);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($artist);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_artist_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('artist/new.html.twig', [
    //         'artist' => $artist,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_artist_show', methods: ['GET'])]
    // public function show(Artist $artist): Response
    // {
    //     return $this->render('artist/show.html.twig', [
    //         'artist' => $artist,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'app_artist_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Artist $artist, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(ArtistType::class, $artist);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_artist_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('artist/edit.html.twig', [
    //         'artist' => $artist,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_artist_delete', methods: ['POST'])]
    // public function delete(Request $request, Artist $artist, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($artist);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_artist_index', [], Response::HTTP_SEE_OTHER);
    // }
}
