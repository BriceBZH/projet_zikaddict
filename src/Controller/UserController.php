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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\FormatRepository;
use App\Repository\CountryRepository;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
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
    public function edit(AuthorizationCheckerInterface $authorization, Request $request, User $user, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $route = $request->query->get('route');
        $idUser = $request->query->get('idUser');
        if ($authorization->isGranted('ROLE_ADMIN')) {
            $admin = true;
        } else {
            $admin = false;
        }
        $param = [];
        if($idUser) { //If there is a parameter like an id (for the user's page)
            $param = ['idUser' => $idUser];
        }
        $form = $this->createForm(UserType::class, $user, [
            'is_admin' => $admin,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pass = $form->get('password')->getData();
            if(!empty($pass)) { //password field is not empty so we change password
                $password_regex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\d\s])(?=.*[a-zA-Z\d\W\S]).{8,}$/"; //@Test123456             
                if(!preg_match($password_regex, $pass)) {
                    $this->addFlash('notice', "Le mot de passe n'est pas assez fort, Il faut 8 caractères, au moins 1 lettre capitale, 1 lettre minuscule, 1 chiffre et 1 caractère spécial");

                    return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
                }
                $user->setPassword($userPasswordHasher->hashPassword($user, $pass));
            } else { //password field is empty so we take old password
                $password = $userRepository->getPasswordById($user->getId());
                $user->setPassword($password);
            }
            $entityManager->flush();

            $this->addFlash('notice', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
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
            
            foreach ($user->getUserAlbumFormats() as $userAlbumFormats) { // Remove relations user_album_format
                $entityManager->remove($userAlbumFormats);
            }

            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('notice', "L'utilisateur a bien été supprimé");
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }
}
