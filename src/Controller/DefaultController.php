<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
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
    public function siteMap(): Response
    {
        return $this->render('default/site-map.html.twig', [

        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig', [

        ]);
    }
}
