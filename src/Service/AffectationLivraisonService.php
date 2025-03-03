<?php
namespace App\Service;

use App\Entity\Livraison;
use App\Entity\Transporteur;
use Doctrine\ORM\EntityManagerInterface;

class AffectationLivraisonService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function affecterTransporteur(Livraison $livraison): ?Transporteur
    {
        $transporteursDisponibles = $this->entityManager->getRepository(Transporteur::class)
            ->findBy(['isDisponible' => true]);

        if (empty($transporteursDisponibles)) {
            throw new \Exception('Aucun transporteur disponible');
        }

        $transporteurAssigné = null;
        $minLivraisons = PHP_INT_MAX;

        foreach ($transporteursDisponibles as $transporteur) {
            $nombreLivraisonsEnCours = count($transporteur->getLivraisons());

            if ($nombreLivraisonsEnCours < $minLivraisons) {
                $minLivraisons = $nombreLivraisonsEnCours;
                $transporteurAssigné = $transporteur;
            }
        }

        if ($transporteurAssigné !== null) {
            $livraison->setTransporteur($transporteurAssigné);
            $this->entityManager->flush();
        }

        return $transporteurAssigné;
    }
}
