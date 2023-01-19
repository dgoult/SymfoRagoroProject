<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Intervenant;
use App\Form\CoursFormType;
use App\Form\IntervenantFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function MongoDB\BSON\toJSON;

class CoursController extends AbstractController
{
    public ManagerRegistry $doctrine;

    function __construct( ManagerRegistry $doctrine ){
        $this->doctrine = $doctrine ;
    }

    /**
     * @Route("/cours/new", name="cours_new")
     */
    public function newCours(Request $request)
    {
        $newCours = new Cours();

        $form = $this->createForm(CoursFormType::class, $newCours);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newCours = $form->getData();
            // Calcul de la durée du cours
            $interval = date_diff($newCours->getDateDebut(), $newCours->getDateFin(), true);
            $newCours->setDureeMinutes(((int)$interval->format("%h") * 60) + (int)$interval->format("%i"));

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($newCours);
            $entityManager->flush();
            $this->addFlash('success', 'Le cours '. $newCours->getId().' à été enregistré avec succés');
        }

        return $this->render('cours/newCours.html.twig',
            ['coursForm' => $form->createView(),
                'title' => "Création d'un cours",
                'cours' => $newCours,
        ]);
    }

    /**
     * @Route("/cours/edit/{id}", name="cours_edit")
     */
    public function editCours(Request $request, $id)
    {
        $cours = $this->doctrine->getRepository(Cours::class)->find($id);

        $form = $this->createForm(CoursFormType::class, $cours);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $cours = $form->getData();
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($cours);
            $entityManager->flush();
            $this->addFlash('success', 'Le cours '.$cours->getNom().' '.$cours->getPrenom().' à été modifié avec succés');
        }

        return $this->render('cours/newCours.html.twig',
            ['coursForm' => $form->createView(),
             'title' => "Création d'un cours",
             'cours' => $cours,
            ]);
    }

    /**
     * @Route("/cours/list", name="cours_list")
     * @param Request $request
     *
     * @return Response
     */
    public function cours(Request $request): Response
    {
        $cours = $this->doctrine->getRepository(Cours::class)->findAll();

        return $this->render('cours/listingCours.html.twig', [
            'cours' => $cours,
            'title' => 'Liste des intervenants'
        ]);

    }
}