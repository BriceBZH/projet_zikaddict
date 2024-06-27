<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ArtistRepository;
use App\Repository\AlbumRepository;
use App\Repository\SongRepository;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search')]
    public function results(Request $request, ArtistRepository $artistRepository, AlbumRepository $albumRepository, SongRepository $songRepository): Response
    {
        $results = [];
        $query = $request->query->get('query');
        $results['artists'] = $artistRepository->findByPartialName($query);
        $results['albums'] = $albumRepository->findByPartialTitle($query);
        $results['songs'] = $songRepository->findByPartialTitle($query);
        return $this->render('search/results.html.twig', [
            'results' => $results,
        ]);
    }
}
