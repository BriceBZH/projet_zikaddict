<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/country')]
class CountryController extends AbstractController
{

    #[Route('/new', name: 'country_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $route = $request->query->get('route');
        $idUser = $request->query->get('idUser');
        $param = [];
        if($idUser) { //s'il y a un paramètre comme un id (pour la page du user)
            $param = ['idUser' => $idUser];
        }

        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $escaped = htmlspecialchars($country->getName(), ENT_QUOTES, 'UTF-8'); // Escape the form data to prevent XSS
            $country->setName($escaped);
            $entityManager->persist($country);
            $entityManager->flush();

            $this->addFlash('notice', 'Le pays est bien ajouté');

            return $this->redirectToRoute($route, $param, Response::HTTP_SEE_OTHER);
        }

        return $this->render('country/new.html.twig', [
            'country' => $country,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'country_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Country $country, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $escaped = htmlspecialchars($country->getName(), ENT_QUOTES, 'UTF-8'); // Escape the form data to prevent XSS
            $country->setName($escaped);
            $entityManager->flush();

            $this->addFlash('notice', 'Le pays à bien été modifié');

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('country/edit.html.twig', [
            'country' => $country,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'country_delete', methods: ['POST'])]
    public function delete(Request $request, Country $country, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$country->getId(), $request->request->get('_token'))) {
            $entityManager->remove($country);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }
}
