<?php

namespace App\Controller;

use App\Entity\Song;
use App\Form\SongType;
use App\Repository\SongRepository;
use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/songs')]
class SongController extends AbstractController
{
    #[Route('/{idSong}', name: 'song', methods: ['GET'])]
    public function displayOne(SongRepository $songRepository, ArtistRepository $artistRepository, int $idSong): Response {
        $song = $songRepository->find($idSong);
        return $this->render("songs/song-show.html.twig", [
            'artists' => $artistRepository->findBySong($song),
            'song' => $song
        ]);
    }

    #[Route('/{id}/edit', name: 'song_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Song $song, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SongType::class, $song);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_song_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('songs/edit.html.twig', [
            'song' => $song,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'song_delete', methods: ['POST'])]
    public function delete(Request $request, Song $song, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$song->getId(), $request->request->get('_token'))) {
            $entityManager->remove($song);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'song_valid', methods: ['POST'])]
    public function valid(Request $request, Song $song, EntityManagerInterface $entityManager, SongRepository $songRepository): Response
    {
        if ($this->isCsrfTokenValid('valid'.$song->getId(), $request->request->get('_token'))) {
            $song = $songRepository->find($song->getId());
            $song->setValid(1);
            $entityManager->persist($song);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }
}
