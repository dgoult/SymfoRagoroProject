<?php

namespace App\Controller;

use App\Helper\ReportingHelper;
use App\Repository\CoursRepository;
use App\Repository\FormationRepository;
use App\Repository\IntervenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/reporting/intervenant', name: 'reporting_intervenant')]
    public function reportingIntervenant(Request $request, FormationRepository $formationRepository, CoursRepository $coursRepository, IntervenantRepository $intervenantRepository) {

        return $this->render('reporting/reportingIntervenant.html.twig', [
            'title' => 'Details Formation',
            'statsIntervenant' => ReportingHelper::statsIntervenant($intervenantRepository),
            'heuresIntervenant' => ReportingHelper::heuresIntervenant($intervenantRepository)
        ]);
    }
}
