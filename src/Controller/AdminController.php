<?php

namespace App\Controller;

use App\Entity\CommentaireCours;
use App\Entity\Formation;
use App\Form\CommentaireCoursType;
use App\Form\FormationFormType;
use App\Helper\ReportingHelper;
use App\Repository\CoursRepository;
use App\Repository\FormationRepository;
use App\Repository\IntervenantRepository;
use App\Repository\MatiereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    public ManagerRegistry $doctrine;

    function __construct( ManagerRegistry $doctrine ){
        $this->doctrine = $doctrine ;
    }

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
    public function showFormationDetails(Request $request, FormationRepository $formationRepository, CoursRepository $coursRepository, IntervenantRepository $intervenantRepository, MatiereRepository $matiereRepository): Response
    {
        $formation = $formationRepository->find(1);
        $totalHoursCours = $coursRepository->getTotalHours();

        return $this->renderForm('admin/formationDetails.html.twig', [
            'title' => 'Details Formation',
            'formation' => $formation,
            'dureeTotalCours' => $totalHoursCours,
            "qteIntervenant" => count($intervenantRepository->findAll()),
            "qteHeureAttribue" => ReportingHelper::totalMinutesMatieres($matiereRepository),
            'statsIntervenant' => ReportingHelper::statsIntervenant($intervenantRepository),
            'heuresIntervenant' => ReportingHelper::heuresIntervenant($intervenantRepository),
        ]);
    }
}
