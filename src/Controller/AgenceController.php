<?php

namespace App\Controller;

use App\Repository\LogementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//Attribut de la classe qui permet de mutualiser des informations
#[Route('/agence', name: 'logement_')]
class AgenceController extends AbstractController
{
    #[Route('/list', name: 'list', methods: 'GET')]
    public function list(LogementRepository $logementRepository): Response
    {
        //1 - Récupère l'ensemble des logements en DB
        $logements = $logementRepository->findAll();
        dump($logements);
        return $this->render('agence/list.html.twig', [
            'logements' => $logements
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id, LogementRepository $logementRepository): Response
    {
        $logement = $logementRepository->find($id);

        if(!$logement){
            //Lance une erreur 404 si la série n'existe pas
            throw $this->createNotFoundException("Oops ! Ce logement n'existe pas !");
        }

        dump($logement);

        return $this->render('logement/show.html.twig', [
            'logement' => $logement
        ]);
    }
}
