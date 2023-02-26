<?php

namespace App\Controller;

use App\Entity\Logement;
use App\Form\LogementType;
use App\Repository\LogementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/add', name: 'add')]
    public function add(LogementRepository $logementRepository, Request $request)
    {
        $logement = new Logement();

        //1 - Création d'une instance de form lié à une instance de Logement
        $logementForm = $this->createForm(LogementType::class, $logement);

        //2 - Méthode qui extrait les éléments du formulaire de la requête
        $logementForm->handleRequest($request);

        //3 - Traitement si le formulaire est soumis et valide (valide au regard des contraintes de validation des attributs de l'entité)
        if($logementForm->isSubmitted() && $logementForm->isValid()){
            //Sauvegarde en DB la nouvelle série saisie par l'utilisateur
            $logementRepository->save($logement, true);

            //Message flash d'info d'ajout du logement OK
            $this->addFlash('success', 'Le logement a bien été ajouté !');

            //Redirige vers la page de détail du logement
            return $this->redirectToRoute('logement_show', ['id' => $logement->getId()]);
        }

        dump($logement);

        return $this->render('logement/add.html.twig', [
            'logementForm' => $logementForm->createView()
        ]);






    }
}
