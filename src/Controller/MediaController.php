<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArtistRepository;
use App\Repository\AlbumRepository;

#[Route('/media')]
class MediaController extends AbstractController
{
    #[Route('/{id}/edit', name: 'media_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Media $medium, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //new media is not empty so we modify old media
            $urlMedia =  $form->get('mediaUrl')->getData();
            $uploadMedia =  $form->get('mediaUpload')->getData();
            $mediaName =  $medium->getAlt();
            $oldMedia = $medium->getUrl();
            if(!empty($urlMedia)) { // if album media is not empty
                $img = '../public/build/images/'.$mediaName;
                $content = @file_get_contents($urlMedia);
                //remove old picture from assets
                unlink('../public/build/images/'.$oldMedia);
                if ($content === false) {
                    $this->addFlash('notice', "Erreur lors du téléchargement de l'image depuis l'URL.");

                    return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
                } else {
                    $extension = pathinfo($urlMedia, PATHINFO_EXTENSION);
                    $img .= '.'.$extension;
                    $mediaNameImg = $mediaName.'.'.$extension;
                    file_put_contents($img, $content);
                }
                $media = $urlMedia;
            } else if(!empty($uploadMedia)) { // if url media is not empty
                $mediaNameImg = $mediaName.'.'.$uploadMedia->guessExtension();
                //remove old picture from assets
                unlink('../public/build/images/'.$oldMedia); 
                try {
                    $uploadMedia->move(
                        $this->getParameter('media_directory'),
                        $mediaNameImg
                    );      
                } catch(FileException $e) {
                    $this->addFlash('notice', "Erreur lors de l\'upload du fichier".e->getMessage());

                    return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
                }
                $media = "Upload";
            }
            if(!empty($urlMedia) || !empty($uploadMedia)) {
                //update media for artist
                $medium->setUrl($mediaNameImg);
                $medium->setAlt($mediaName);
                $medium->setUrlSource($media);
            }
            $entityManager->flush();

            $this->addFlash('notice', "Le média a bien été modifié");

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('media/edit.html.twig', [
            'medium' => $medium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'media_delete', methods: ['POST'])]
    public function delete(Request $request, Media $medium, EntityManagerInterface $entityManager, AlbumRepository $albumRepository, ArtistRepository $artistRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medium->getId(), $request->request->get('_token'))) {

            if (($albumRepository->countByMedia($medium->getId()) > 0) || ($artistRepository->countByMedia($medium->getId()) > 0) ) {
                $this->addFlash('notice', 'Vous ne pouvez pas supprimer ce média car il est associé à un ou plusieurs albums ou artistes.');
                return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
            }

            $this->addFlash('notice', 'Le média a bien été supprimé');
            $entityManager->remove($medium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }
}
