<?php

namespace App\Controller;

use App\Entity\Song;
use App\Form\SongType;
use App\Repository\SongRepository;
use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/songs')]
class SongController extends AbstractController
{
    #[Route('/new', name: 'song_new', methods: ['GET', 'POST'])]
    public function new(AuthorizationCheckerInterface $authorization, Request $request, EntityManagerInterface $entityManager): Response
    {
        $route = $request->query->get('route');
        $idUser = $request->query->get('idUser');
        if ($authorization->isGranted('ROLE_ADMIN')) { //if user as admin role, valid is TRUE
            $valid = true;
        } else {
            $valid = false;
        }
        $param = [];
        if($idUser) { //If there is a parameter like an id (for the user's page)
            $param = ['idUser' => $idUser];
        } 

        $song = new Song();
        $form = $this->createForm(SongType::class, $song);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { //if user is admin, valid is true, else valid is false
            $song->setValid($valid);

            foreach ($song->getArtists() as $artist) { //add song in artist's collection
                $artist->addSong($song);
            }

            foreach ($song->getAlbums() as $album) { //add song in album's collection
                $album->addSong($song);
            }

            $entityManager->persist($song);
            $entityManager->flush();

            $this->addFlash('notice', "La chanson est bien ajouté");

            return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
        }

        return $this->render('songs/new.html.twig', [
            'song' => $song,
            'form' => $form,
        ]);
    }

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

            $this->addFlash('notice', 'La chanson a bien été modifiée');

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
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
