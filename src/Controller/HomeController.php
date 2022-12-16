<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function home(): Response
    {

        return $this->render('home/index.html.twig', [
            'title'=>'Accueil'
        ]);
    }

    /**
     * @Route("/produits/affichage-creneau-journee")
     */
    public function showSlot(): Response {
        return new Response("Future page d'affichage de créneau.");
    }

    /**
     * @Route("/produits/{var}")
     */
    public function showJokerSlot($var): Response
    {
        //new Response(sprintf("Future page d'affichage de créneau : %s",$var));
        $comments = [
            'Je suis le premier coms',
            '2 suis le premier foirst',
            '3 suis le qzdqzd coms',
            '4 QZD le qzd<qzd<qdzQZDQD',
        ];

        return $this->render('slot/affichageSot.html.twig', [
            'title'=>ucwords(str_replace('-', ' ', $var)),
            'comments'=>$comments,
        ]);
    }
}