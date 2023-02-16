<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function home(): Response
    {
//        $hasAccess = $this->isGranted('ROLE_ADMIN');
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/admin-home.html.twig', [
            'title'=>'Accueil'
        ]);
    }
}