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
