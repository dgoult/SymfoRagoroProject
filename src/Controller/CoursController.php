<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursFormType;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use DateTime;
use DateTimeZone;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Timezone;

class CoursController extends AbstractController
{
    public ManagerRegistry $doctrine;

    function __construct( ManagerRegistry $doctrine ){
        $this->doctrine = $doctrine ;
    }

    /**
     * @Route("/calendar", name="app_cours_calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('calendar.html.twig');
    }

    #[Route('/cours/calender_new', name: 'app_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CoursRepository $coursRepository): Response
    {
        $cour = new Cours();
        $form = $this->createForm(CoursFormType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Calcul de la durée du cours
            $interval = date_diff($cour->getDateDebut(), $cour->getDateFin(), true);
            $cour->setDureeMinutes(((int)$interval->format("%h") * 60) + (int)$interval->format("%i"));
            $coursRepository->save($cour, true);

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cours/newCours.html.twig', [
            'cour' => $cour,
            'coursForm' => $form,
            'title' => 'Nouveau cours'
        ]);
    }

    #[Route('/cours/calendar/{id}', name: 'app_cours_show', methods: ['GET'])]
    public function show(Cours $cour): Response
    {
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
            'action' => 'Créer'
        ]);
    }

    /**
     * @Route("/cours/new", name="cours_new")
     */
    public function newCours(Request $request)
    {
        $newCours = new Cours();

        $form = $this->createForm(CoursFormType::class, $newCours);
        $form->get('date_cours')->setData(new DateTime('now',  new DateTimeZone('Europe/Paris')));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newCours = $this->getCoursData($form);
            $this->addFlash('success', 'Le cours '. $newCours->getId().' à été enregistré avec succés');
        }

        return $this->render('cours/newCours.html.twig',
            ['coursForm' => $form->createView(),
             'title' => "Modification d'un cours",
             'cours' => $newCours,
             'action' => "Créer"
            ]);
    }

    /**
     * @Route("/cours/edit/{id}", name="cours_edit")
     * @throws Exception
     */
    public function editCours(Request $request, $id): Response
    {
        $cours = $this->doctrine->getRepository(Cours::class)->find($id);

        $form = $this->createForm(CoursFormType::class, $cours);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $cours = $this->getCoursData($form);
            $this->addFlash('success', 'Le cours '.$cours->getNom().' à été modifié avec succés');
        }

        return $this->render('cours/newCours.html.twig',
            ['coursForm' => $form->createView(),
             'title' => "Création d'un cours",
             'cours' => $cours,
             'action' => "Modifier"
            ]);
    }
    /**
     * @Route("/cours/list", name="cours_list")
     * @param Request $request
     *
     * @return Response
     */
    public function cours(Request $request): Response
    {
        $cours = $this->doctrine->getRepository(Cours::class)->findAll();

        return $this->render('cours/listingCours.html.twig', [
            'cours' => $cours,
            'title' => 'Liste des intervenants'
        ]);

    }

    /**
     * @Route("/cours/delete/{id}", name="cours_delete")
     */
    public function deleteCours(Request $request, $id)
    {
        $entityManager = $this->doctrine->getManager();
        $entity = $entityManager->getRepository(Cours::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cours entity.');
        }
        $entityManager->remove($entity);
        $entityManager->flush();
        return $this->redirectToRoute('cours_list');

    }

    /**
     * @param FormInterface $form
     *
     * @return mixed
     */
    public function getCoursData(FormInterface $form): mixed
    {
        $cours = $form->getData();

        // Calcul de la durée du cours
        $interval = date_diff($cours->getHeureDebut(), $cours->getHeureFin(), true);
        $cours->setDureeMinutes(((int)$interval->format("%h") * 60) + (int)$interval->format("%i"));
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($cours);
        $entityManager->flush();
        return $cours;
    }


}
