<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\ArtistRepository;
use App\Repository\AlbumRepository;
use App\Repository\SongRepository;
use App\Repository\GenreRepository;
use App\Repository\UserAlbumFormatRepository;
use App\Repository\FormatRepository;
use App\Repository\CountryRepository;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/admin', name: 'admin', methods: ['GET'])]
    public function admin(UserRepository $userRepository, SongRepository $songRepository, AlbumRepository $albumRepository, ArtistRepository $artistRepository, MediaRepository $mediaRepository, CountryRepository $countryRepository, FormatRepository $formatRepository, GenreRepository $genreRepository): Response
    {
        return $this->render("user/admin.html.twig", [
            'artists' => $artistRepository->findAll(),
            'artistsNotValid' => $artistRepository->findByNotValid(),
            'albums' => $albumRepository->findAll(),
            'albumsNotValid' => $albumRepository->findByNotValid(),
            'songs' => $songRepository->findAll(),
            'songsNotValid' => $songRepository->findByNotValid(),
            'genres' => $genreRepository->findAll(),
            'formats' => $formatRepository->findAll(),
            'users' => $userRepository->findAll(),
            'countries' => $countryRepository->findAll(),
            'medias' => $mediaRepository->findAll(),
        ]);
    }

    #[Route('/profile/{idUser}', name: 'profile', methods: ['GET'])]
    public function profile(UserRepository $userRepository, UserAlbumFormatRepository $userAlbumFormatRepository, int $idUser): Response
    {
        $user = $userRepository->find($idUser);
        $typeCollection = "Collection";
        $typeSearch = "Search";
        $userAlbumsCollection = $userAlbumFormatRepository->findByUserCollectionType($user, $typeCollection);
        $userAlbumsSearch = $userAlbumFormatRepository->findByUserCollectionType($user, $typeSearch);
        return $this->render("user/profile.html.twig", [
            'user' => $user,
            'userAlbumsCollection' => $userAlbumsCollection,
            'userAlbumsSearch' => $userAlbumsSearch,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
