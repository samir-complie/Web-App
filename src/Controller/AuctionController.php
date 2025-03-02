<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Historique;
use App\Entity\ProduitEnchere;
use DateTime;

final class AuctionController extends AbstractController
{
    #[Route('/auction', name: 'app_auction')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Fetch the latest product (or specific one you need)
        $produitEnchere = $entityManager->getRepository(ProduitEnchere::class)->findOneBy([], ['id' => 'DESC']);

        // Pass the description to the template
        return $this->render('Auction/index.html.twig', [
            'controller_name' => 'AuctionController',
            'product_description' => $produitEnchere ? $produitEnchere->getDescription() : 'Aucune description disponible',
            'image_produit' =>$produitEnchere ? $produitEnchere->getPathImg() : 'Aucune image disponible', 
        ]);
    }


    #[Route('/historique', name: 'historique', methods: ['GET'])]
    public function historique(EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupérer tous les enregistrements depuis l'entité Historique
        $historiques = $entityManager->getRepository(Historique::class)->findAll();

        // Transformer les objets en tableau JSON
        $data = array_map(function (Historique $historique) {
            return [
                'id' => $historique->getId(),
                'offre' => $historique->getOffre(),
                'date' => $historique->getDate()->format('Y-m-d H:i:s'),
                   ];
        }, $historiques);

        return new JsonResponse($data);
    }
    #[Route('/offre', name: 'offre', methods: ['GET'])]
    public function offre(EntityManagerInterface $entityManager): JsonResponse
    {
        // Fetch the latest "Historique" entry
        $offre = $entityManager->getRepository(Historique::class)->findOneBy([], ['id' => 'DESC']);
    
        if (!$offre) {
            return new JsonResponse(['offre' => 'Aucune offre disponible'], Response::HTTP_NOT_FOUND);
        }
    
        // Return only the 'offre' value in the response
        return new JsonResponse(['offre' => $offre->getOffre()]);
    }
    

    #[Route('/auction/update-offer', name: 'update_offer', methods: ['POST'])]
    public function updateOffer(EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupérer la dernière offre
        $lastOffer = $entityManager->getRepository(Historique::class)->findOneBy([], ['date' => 'DESC']);

        // Déterminer le nouveau montant
        $newAmount = $lastOffer ? $lastOffer->getOffre() + 50 : 50;

        // Créer une nouvelle entrée dans l'historique
        $newOffer = new Historique();
        $newOffer->setOffre($newAmount);
        $newOffer->setDate(new DateTime());

        $entityManager->persist($newOffer);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Nouvelle offre ajoutée',
            'new_offer' => $newAmount,
            'date' => $newOffer->getDate()->format('Y-m-d H:i:s'),
        ]);
    }
    #[Route('/newoffre', name: 'newoffer', methods: ['POST'])]
    public function getLastOfferWithAddition(EntityManagerInterface $entityManager): Response
    {
        // Récupération du dernier historique trié par ID décroissant
        $historique = $entityManager->getRepository(Historique::class)
        ->findOneBy([], ['id' => 'DESC']);
        $produitenchere = $entityManager->getRepository(ProduitEnchere::class)
        ->findOneBy([], ['id' => 'DESC']);
    
        // Vérification si une valeur a été trouvée
        if ($historique) {
            $lastOffer = $historique->getOffre();
            // Ajout de 50 à la dernière offre
            $newOffer = $lastOffer + 50;
    
            // Création d'une nouvelle ligne Historique
            $newHistorique = new Historique();
            $newHistorique->setOffre($newOffer);
            $newHistorique->setDate(new \DateTime());
    
            $entityManager->persist($newHistorique);
            $entityManager->flush();
    
            return new Response('', Response::HTTP_NO_CONTENT);
        }
        else {
            $lastOffer = $produitenchere->getPrixI();
            // Ajout de 50 à la dernière offre
            $newOffer = $lastOffer + 50;
    
            // Création d'une nouvelle ligne Historique
            $newHistorique = new Historique();
            $newHistorique->setOffre($newOffer);
            $newHistorique->setDate(new \DateTime());
    
            $entityManager->persist($newHistorique);
            $entityManager->flush();
    
            return new Response('', Response::HTTP_NO_CONTENT);
        }
        // Si aucun historique n'a été trouvé, retourner une réponse avec un message
        return new Response('Aucun historique trouvé', Response::HTTP_NOT_FOUND);
    }
    
}
