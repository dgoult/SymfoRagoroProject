<?php

namespace App\Controller;

use App\Entity\Intervenant;
use App\Form\IntervenantFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function MongoDB\BSON\toJSON;

class IntervenatController extends AbstractController
{
    public ManagerRegistry $doctrine;

    function __construct( ManagerRegistry $doctrine ){
        $this->doctrine = $doctrine ;
    }

    /**
     * * Exemple Ajout d'une entité
     ************ Route("/intervenant/exemple", name="intervenant_index")
     */
    public function exemple(): Response
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
     * * Exemple Récupération d'une entité
     ************* Route("/intervenant/exempleShow/{id}", name="intervenant_show")
     */
    public function exempleShow($id): Response
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
     * @Route("/intervenant/new", name="intervenant_new")
     */
    public function newIntervenant(Request $request)
    {
        $newIntervenant = new Intervenant();

        $form = $this->createForm(IntervenantFormType::class, $newIntervenant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newIntervenant = $form->getData();
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($newIntervenant);
            $entityManager->flush();
            $this->addFlash('success', 'L\'intervenant '.$newIntervenant->getName().' '.$newIntervenant->getPrenom().' à été enregistrer avec succés');
        }

        return $this->render('intervenant/newIntervenant.html.twig',
            ['intervenantForm' => $form->createView(),
                'title' => "Création d'un intervenant",
                'intervenant' => $newIntervenant,
        ]);
    }
}