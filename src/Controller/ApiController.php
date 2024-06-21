<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\DeezerService;

class ApiController extends AbstractController
{
    private $deezerService;

    public function __construct(DeezerService $deezerService)
    {
        $this->deezerService = $deezerService;
    }

    #[Route('/AlbumsUrl', name: 'AlbumsUrl')]
    public function AlbumsUrl(DeezerService $deezerService): Response
    {
        $api_albums_url = $this->deezerService->getAlbumsUrl();
        $data = json_decode($api_albums_url, true);
        return new JsonResponse($data);
    }

    #[Route('/AlbumUrl/{idAlbum}', name: 'AlbumUrl')]
    public function AlbumUrl(DeezerService $deezerService, int $idAlbum): Response
    {
        $api_album_url = $this->deezerService->getAlbumUrl($idAlbum);
        $data = json_decode($api_album_url, true);
        return new JsonResponse($data);
    }
}
