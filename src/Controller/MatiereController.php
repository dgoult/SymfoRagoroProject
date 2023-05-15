<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\Intervenant;
use App\Form\MatiereFormType;
use App\Form\IntervenantFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatiereController extends AbstractController
{
    public ManagerRegistry $doctrine;

    function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/matiere/new", name="matiere_new")
     */
    public function newMatiere(Request $request)
    {
        $newMatiere = new Matiere();

        $form = $this->createForm(MatiereFormType::class, $newMatiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newMatiere = $form->getData();

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($newMatiere);
            $entityManager->flush();
            $this->addFlash('success', 'Le matiere ' . $newMatiere->getIntitule() . ' à été enregistré avec succés');
        }

        return $this->render(
            'matiere/newMatiere.html.twig',
            [
                'matiereForm' => $form->createView(),
                'title'       => "Création d'un matiere",
                'matiere'     => $newMatiere,
                'action'      => 'Créer'
            ]
        );
    }

    /**
     * @Route("/matiere/edit/{id}", name="matiere_edit")
     */
    public function editMatiere(Request $request, $id)
    {
        $matiere = $this->doctrine->getRepository(Matiere::class)->find($id);

        $form = $this->createForm(MatiereFormType::class, $matiere);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $matiere = $form->getData();
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($matiere);
            $entityManager->flush();
            $this->addFlash('success', 'Le matiere ' . $matiere->getIntitule() . ' à été modifié avec succés');
        }

        return $this->render(
            'matiere/newMatiere.html.twig',
            [
                'matiereForm' => $form->createView(),
                'title'       => "Création d'un matiere",
                'matiere'     => $matiere,
                'action'      => 'Modifier'
            ]
        );
    }

    /**
     * @Route("/matiere/list", name="matiere_list")
     * @param Request $request
     *
     * @return Response
     */
    public function matiere(Request $request): Response
    {
        $matiere = $this->doctrine->getRepository(Matiere::class)->findAll();

        return $this->render('matiere/listingMatiere.html.twig', [
            'matieres' => $matiere,
            'title'    => 'Liste des intervenants'
        ]);
    }

    /**
     * @Route("/matiere/delete/{id}", name="matiere_delete")
     */
    public function deleteMatiere(Request $request, $id): RedirectResponse
    {
        $entityManager = $this->doctrine->getManager();
        $entity = $entityManager->getRepository(Matiere::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Matiere entity.');
        }
        $entityManager->remove($entity);
        $entityManager->flush();
        return $this->redirectToRoute('matiere_list');
    }
}