<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArtistRepository;
use App\Repository\AlbumRepository;
use App\Repository\SongRepository;
use App\Repository\MediaRepository;
use App\Services\DeezerService;

class DefaultController extends AbstractController
{
    private $deezerService;

    public function __construct(DeezerService $deezerService)
    {
        $this->deezerService = $deezerService;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/test', name: 'test')]
    public function test(DeezerService $deezerService): Response
    {
        $api_albums_url = $this->deezerService->getAlbumsUrl();
        $data = json_decode($api_albums_url, true);
        return new JsonResponse($data);
    }

    #[Route('/test2/{idAlbum}', name: 'test2')]
    public function test2(DeezerService $deezerService, int $idAlbum): Response
    {
        $api_album_url = $this->deezerService->getAlbumUrl($idAlbum);
        $data = json_decode($api_album_url, true);
        return new JsonResponse($data);
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

    #[Route('/error/{code}', name: 'error')]
    public function error(int $code): Response
    {
        if($code === 404) {
            return $this->render('default/404.html.twig');
        }
        return $this->render('default/error.html.twig', [
            'code' => $code
        ]);
    }
}
