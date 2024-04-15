<?php

namespace App\Controller;

use App\Entity\UserAlbumFormat;
use App\Form\UserAlbumFormatType;
use App\Repository\UserAlbumFormatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/album/format')]
class UserAlbumFormatController extends AbstractController
{
    // #[Route('/', name: 'app_user_album_format_index', methods: ['GET'])]
    // public function index(UserAlbumFormatRepository $userAlbumFormatRepository): Response
    // {
    //     return $this->render('user_album_format/index.html.twig', [
    //         'user_album_formats' => $userAlbumFormatRepository->findAll(),
    //     ]);
    // }

    // #[Route('/new', name: 'app_user_album_format_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $userAlbumFormat = new UserAlbumFormat();
    //     $form = $this->createForm(UserAlbumFormatType::class, $userAlbumFormat);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($userAlbumFormat);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_user_album_format_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('user_album_format/new.html.twig', [
    //         'user_album_format' => $userAlbumFormat,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_user_album_format_show', methods: ['GET'])]
    // public function show(UserAlbumFormat $userAlbumFormat): Response
    // {
    //     return $this->render('user_album_format/show.html.twig', [
    //         'user_album_format' => $userAlbumFormat,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'app_user_album_format_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, UserAlbumFormat $userAlbumFormat, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(UserAlbumFormatType::class, $userAlbumFormat);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_user_album_format_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('user_album_format/edit.html.twig', [
    //         'user_album_format' => $userAlbumFormat,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}/{idUser}', name: 'user_album_format_delete', methods: ['POST'])]
    public function delete(Request $request, int $idUser, UserAlbumFormat $userAlbumFormat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userAlbumFormat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($userAlbumFormat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile', ['idUser' => $idUser], Response::HTTP_SEE_OTHER);
    }
}
