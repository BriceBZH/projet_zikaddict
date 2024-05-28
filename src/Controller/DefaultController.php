<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArtistRepository;
use App\Repository\AlbumRepository;
use App\Repository\SongRepository;
use App\Repository\MediaRepository;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/credits', name: 'credits')]
    public function credits(MediaRepository $mediaRepository): Response
    {
        return $this->render('default/credits.html.twig', [
            'medias' => $mediaRepository->findAll(),
        ]);
    }

    #[Route('/presentation', name: 'presentation')]
    public function presentation(): Response
    {
        return $this->render('default/presentation.html.twig', [

        ]);
    }

    #[Route('/site-map', name: 'site-map')]
    public function siteMap(ArtistRepository $artistRepository, AlbumRepository $albumRepository, SongRepository $songRepository): Response
    {
        return $this->render('default/site-map.html.twig', [
            'artists' => $artistRepository->findByValid(),
            'albums' => $albumRepository->findByValid(),
            'songs' => $songRepository->findByValid(),
        ]);
    }

    #[Route('/politique', name: 'politique')]
    public function politique(): Response
    {
        return $this->render('default/politique.html.twig', [

        ]);
    }
}
