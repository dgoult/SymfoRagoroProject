<?php

namespace App\Controller;

use App\Entity\Intervenant;
use App\Form\IntervenantFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IntervenatController extends AbstractController
{
    public ManagerRegistry $doctrine;

    function __construct( ManagerRegistry $doctrine ){
        $this->doctrine = $doctrine ;
    }

    /**
     * @Route("/intervenant/index", name="intervenant_index")
     */
    public function index(): Response
    {
        //Récupération de l'objet EntityManager via getDoctrine()
        $entityManager = $this->doctrine->getManager();

        $inter = new Intervenant();
        $inter->setName("Leclerc");
        $inter->setPrenom("Arthur");
        $inter->setSpecialiteprofessionnelle("Pilote de F2");

        //Indique que l'on veux persister ces données
        $entityManager->persist($inter);

        //Execute la requete
        $entityManager->flush();

        return new Response("Création de l'intervenant ".$inter->getName()." ".$inter->getPrenom()." avec l'id ".$inter->getId());
    }
    /**
     * @Route("/intervenant/show/{id}", name="intervenant_show")
     */
    public function show($id): Response
    {
        $inter = $this->doctrine
            ->getRepository(Intervenant::class)
            ->find($id);
        if (!$inter){
            throw $this->createNotFoundException(
                "Pas d'intervenant pour cet id : ".$id
            );
        }
        return new Response('id numéro :'.$id.
            ", nom : ".$inter->getName().
            ", prénom : ".$inter->getPrenom());
    }
    /**
     * @Route("/intervenant/create", name="intervenant_create")
     */
    public function new()
    {
        $newIntervenant = new Intervenant();

        $form = $this->createForm(IntervenantFormType::class, $newIntervenant);

        return $this->render('intervenant/newIntervenant.html.twig',
            ['intervenantForm' => $form->createView(),
                'title' => "Création d'un intervenant",
        ]);
    }
}