<?php

namespace App\Controller;

use App\Helper\ReportingHelper;
use App\Repository\CoursRepository;
use App\Repository\IntervenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportingController extends AbstractController
{
    #[Route('/reporting', name: 'app_reporting')]
    public function index(): Response
    {
        return $this->render('reporting/index.html.twig', [
            'controller_name' => 'ReportingController',
        ]);
    }
}
