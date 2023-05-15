<?php

namespace App\Controller;

use App\Entity\CommentaireCours;
use App\Form\CommentaireCoursType;
use App\Repository\FormationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('admin', name: 'admin_home', methods: ['GET'])]
    public function home(Request $request): Response
    {
//        $hasAccess = $this->isGranted('ROLE_ADMIN');
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $commentaire = new CommentaireCours();
        $form = $this->createForm(CommentaireCoursType::class, $commentaire);
        $form->handleRequest($request);

        return $this->render('admin/admin-home.html.twig', [
            'title'=>'Accueil',
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/formation-details', name: 'admin_formation', methods: ['GET'])]
    public function showFormationDetails(Request $request, FormationRepository $repository) {
        $formation = $repository->findAll()[0];

        return $this->render('admin/formationDetails.html.twig', [
            'title' => 'Details Formation',
            'formation' => $formation
        ]);
    }
}
