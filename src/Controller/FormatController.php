<?php

namespace App\Controller;

use App\Entity\Format;
use App\Form\FormatType;
use App\Repository\FormatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/format')]
class FormatController extends AbstractController
{
    // #[Route('/', name: 'app_format_index', methods: ['GET'])]
    // public function index(FormatRepository $formatRepository): Response
    // {
    //     return $this->render('format/index.html.twig', [
    //         'formats' => $formatRepository->findAll(),
    //     ]);
    // }

    // #[Route('/new', name: 'app_format_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $format = new Format();
    //     $form = $this->createForm(FormatType::class, $format);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($format);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_format_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('format/new.html.twig', [
    //         'format' => $format,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_format_show', methods: ['GET'])]
    // public function show(Format $format): Response
    // {
    //     return $this->render('format/show.html.twig', [
    //         'format' => $format,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'app_format_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Format $format, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(FormatType::class, $format);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_format_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('format/edit.html.twig', [
    //         'format' => $format,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_format_delete', methods: ['POST'])]
    // public function delete(Request $request, Format $format, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$format->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($format);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_format_index', [], Response::HTTP_SEE_OTHER);
    // }
}
