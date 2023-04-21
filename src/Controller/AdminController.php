<?php

namespace App\Controller;

use App\Entity\CommentaireCours;
use App\Form\CommentaireCoursType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function home(Request $request): Response
    {
//        $hasAccess = $this->isGranted('ROLE_ADMIN');
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $commentaire = new CommentaireCours();
        $form = $this->createForm(CommentaireCoursType::class, $commentaire);
        $form->handleRequest($request);

        return $this->renderForm('admin/admin-home.html.twig', [
            'title'=>'Accueil',
            'form' => $form
        ]);
    }
}