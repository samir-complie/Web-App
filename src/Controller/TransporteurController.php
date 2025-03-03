<?php

namespace App\Controller;

use App\Entity\Transporteur;
use App\Form\TransporteurType;
use App\Repository\TransporteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



#[Route('/transporteur')]
final class TransporteurController extends AbstractController
{
    #[Route(name: 'app_transporteur_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {   
        $nom = $request->query->get('nom');
        $prenom = $request->query->get('prenom');
    
        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('t')
            ->from(Transporteur::class, 't');
    
        if (!empty($nom)) {
            $queryBuilder->andWhere('t.nom LIKE :nom')
                ->setParameter('nom', '%' . $nom . '%');
        }
    
        if (!empty($prenom)) {
            $queryBuilder->andWhere('t.prenom LIKE :prenom')
                ->setParameter('prenom', '%' . $prenom . '%');
        }
    
        $transporteurs = $queryBuilder->getQuery()->getResult();
        return $this->render('transporteur/index.html.twig', [
            'transporteurs' => $transporteurs,
        ]);
    }

    #[Route('/new', name: 'app_transporteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transporteur = new Transporteur();
        $form = $this->createForm(TransporteurType::class, $transporteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transporteur);
            $entityManager->flush();

            $this->addFlash('success', 'Le transporteur a été créé avec succès.');

            return $this->redirectToRoute('app_transporteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transporteur/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_transporteur_show', methods: ['GET'])]
    public function show(Transporteur $transporteur): Response
    {
        $qrCodePath = $this->getParameter('kernel.project_dir') . '/public/images/qr_codes/qr_' . $transporteur->getId() . '.svg';
    if (!file_exists($qrCodePath)) {
        $this->generateQr($transporteur);
    }
        return $this->render('transporteur/show.html.twig', [
            'transporteur' => $transporteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transporteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transporteur $transporteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransporteurType::class, $transporteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le transporteur a été modifié avec succès.');

            return $this->redirectToRoute('app_transporteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transporteur/edit.html.twig', [
            'transporteur' => $transporteur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_transporteur_delete', methods: ['POST'])]
    public function delete(Request $request, Transporteur $transporteur, EntityManagerInterface $entityManager): Response
    {
        if (!$transporteur->getLivraisons()->isEmpty()) {
            $this->addFlash('error', 'Ce transporteur ne peut pas être supprimé car il a encore des livraisons en cours.');
            return $this->redirectToRoute('app_transporteur_index', ['id' => $transporteur->getId()]);
        }


        if ($this->isCsrfTokenValid('delete' . $transporteur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($transporteur);
            $entityManager->flush();

            $this->addFlash('success', 'Le transporteur a été supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Token CSRF invalide.');
        }
        

        return $this->redirectToRoute('app_transporteur_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/generate-qr', name: 'app_transporteur_generate_qr', methods: ['GET'])]
    public function generateQr(Transporteur $transporteur): Response
    {
    
       $infoTransporteur = "ID: " . $transporteur->getId() . "\n" . 
                            "Nom: " . $transporteur->getNom() . "\n" . 
                            "Prénom: " . $transporteur->getPrenom() . "\n" . 
                            "Disponibilité: " . ($transporteur->isDisponible() ? 'Disponible' : 'Non disponible');
        
        $qrCode = new QrCode($infoTransporteur);
        $qrCode->setSize(300);  
        $qrCode->setMargin(10); 
        
        $writer = new SvgWriter();
        $path = $this->getParameter('kernel.project_dir') . '/public/images/qr_codes/qr_' . $transporteur->getId() . '.svg';
    
        $dir = dirname($path);
            if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
         }
        
    try {
        $svgContent = $writer->write($qrCode)->getString();
        file_put_contents($path, $svgContent);

        $this->addFlash('success', 'QR Code généré avec succès !');
        
    } catch (\Exception $e) {
        $this->addFlash('error', 'Erreur : l\'image du QR Code n\'a pas pu être générée.');
    }
        return $this->redirectToRoute('app_transporteur_show', [
            'id' => $transporteur->getId()
        ]);
    }
    
}