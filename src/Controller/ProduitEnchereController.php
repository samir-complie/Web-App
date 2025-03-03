<?php

namespace App\Controller;

use App\Entity\ProduitEnchere;
use App\Form\ProduitEnchereType;
use App\Repository\ProduitEnchereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/produit/enchere')]
final class ProduitEnchereController extends AbstractController{
    #[Route(name: 'app_produit_enchere_index', methods: ['GET'])]
    public function index(ProduitEnchereRepository $produitEnchereRepository): Response
    {
        return $this->render('produit_enchere/index.html.twig', [
            'produit_encheres' => $produitEnchereRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produit_enchere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produitEnchere = new ProduitEnchere();
        $form = $this->createForm(ProduitEnchereType::class, $produitEnchere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produitEnchere);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_enchere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit_enchere/new.html.twig', [
            'produit_enchere' => $produitEnchere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_enchere_show', methods: ['GET'])]
    public function show(ProduitEnchere $produitEnchere): Response
    {
        return $this->render('produit_enchere/show.html.twig', [
            'produit_enchere' => $produitEnchere,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_enchere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProduitEnchere $produitEnchere, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitEnchereType::class, $produitEnchere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_enchere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit_enchere/edit.html.twig', [
            'produit_enchere' => $produitEnchere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_enchere_delete', methods: ['POST'])]
    public function delete(Request $request, ProduitEnchere $produitEnchere, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produitEnchere->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($produitEnchere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_enchere_index', [], Response::HTTP_SEE_OTHER);
    }
}
