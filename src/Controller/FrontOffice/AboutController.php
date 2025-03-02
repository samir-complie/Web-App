<?php

namespace App\Controller\FrontOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Historique;

final class AboutController extends AbstractController {
    #[Route('/about', name: 'app_front_office_about')]
    public function index(): Response {
        return $this->render('front_office/about/about.html.twig', [
            'controller_name' => 'FrontOffice/AboutController',
        ]);
    }

    #[Route('/historique', name: 'historique', methods: ['GET'])]
    public function publish(HubInterface $hub, EntityManagerInterface $entityManager): JsonResponse {
        // Récupérer les enregistrements depuis l'entité Historique
        $historiques = $entityManager->getRepository(Historique::class)->findAll();

        // Transformer les objets en tableau JSON
        $data = array_map(function ($historique) {
            return [
                'id' => $historique->getId(),
                'date' => $historique->getDate()->format('Y-m-d H:i:s'),
                'action' => $historique->getOffre() // Remplacez par getAction() si nécessaire
            ];
        }, $historiques);

        return new JsonResponse($data);
    }
}