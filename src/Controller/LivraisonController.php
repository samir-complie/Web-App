<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Entity\Transporteur;
use App\Form\LivraisonType;
use App\Repository\LivraisonRepository;
use App\Service\AffectationLivraisonService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/livraison')]
final class LivraisonController extends AbstractController
{
    private $affectationLivraisonService;
    public function __construct(AffectationLivraisonService $affectationLivraisonService)
    {
        $this->affectationLivraisonService = $affectationLivraisonService;
    }

    #[Route(name: 'app_livraison_index', methods: ['GET'])]
    public function index(LivraisonRepository $livraisonRepository, Request $request): Response
    {
            $livraisons = $livraisonRepository->findAll();
            $etat = $request->query->get('etat', '');
            if ($etat) {
                $livraisons = array_filter($livraisons, function ($livraison) use ($etat) {
                    return $livraison->getEtatLivraison() === $etat;
                });
            }
        return $this->render('livraison/index.html.twig', [
            'livraisons' => $livraisons,
        ]);


    }

    #[Route('/new', name: 'app_livraison_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    { 
        $livraison = new Livraison();
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($livraison->getDateLivraison() === null) {
                $this->addFlash('error', 'Veuillez sélectionner une date de livraison.');
                return $this->redirectToRoute('app_livraison_new');
            }

            $entityManager->persist($livraison);
            $entityManager->flush();

            if ($livraison->getTransporteur() === null) {
                $livraison->setEtatLivraison('Non Affecté');
                $entityManager->flush();
            }




            $this->addFlash('success', 'La livraison a été ajoutée avec succès.');

            return $this->redirectToRoute('app_livraison_index', [], Response::HTTP_SEE_OTHER);
        }
        
      
        
        return $this->render('livraison/new.html.twig', [
            'livraison' => $livraison,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_livraison_show', methods: ['GET'])]
    public function show(Livraison $livraison): Response
    {
        return $this->render('livraison/show.html.twig', [
            'livraison' => $livraison,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_livraison_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livraison $livraison, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($livraison->getDateLivraison() === null) {
                $this->addFlash('error', 'Veuillez sélectionner une date de livraison.');
                return $this->redirectToRoute('app_livraison_edit', ['id' => $livraison->getId()]);
            }

            $entityManager->flush();

            $this->addFlash('success', 'La livraison a été mise à jour avec succès.');

            return $this->redirectToRoute('app_livraison_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livraison/edit.html.twig', [
            'livraison' => $livraison,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_livraison_delete', methods: ['POST'])]
    public function delete(Request $request, Livraison $livraison, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livraison->getId(), $request->get('_token'))) {
            $entityManager->remove($livraison);
            $entityManager->flush();
            $this->addFlash('success', 'La livraison a été supprimée avec succès.');

        }

        return $this->redirectToRoute('app_livraison_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/affecter-transporteur', name: 'app_livraison_affecter_transporteur', methods: ['GET'])]
    public function affecterTransporteur(Livraison $livraison, EntityManagerInterface $entityManager): Response
    {
        if ($livraison->getTransporteur() === null) {
            $transporteur = $entityManager->getRepository(Transporteur::class)->findOneBy(['isDisponible' => true]);
            
            if ($transporteur) {
                $livraison->setTransporteur($transporteur);
                $entityManager->flush();
                $this->addFlash('success', 'Transporteur affecté à la livraison.');
            } else {
                $this->addFlash('error', 'Aucun transporteur disponible.');
            }
        }

        return $this->redirectToRoute('app_livraison_show', ['id' => $livraison->getId()]);
    }


} 