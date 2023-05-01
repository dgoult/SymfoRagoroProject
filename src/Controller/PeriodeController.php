<?php

namespace App\Controller;

use App\Entity\Periode;
use App\Entity\User;
use App\Form\PeriodeFormType;
use DateTime;
use DateTimeZone;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Timezone;

use function MongoDB\BSON\toJSON;
#[Route('/admin')]
class PeriodeController extends AbstractController
{
    public ManagerRegistry $doctrine;

    function __construct( ManagerRegistry $doctrine ){
        $this->doctrine = $doctrine ;
    }

    /**
     * @throws Exception
     */
    #[Route("/periode/new", name: 'periode_new', methods: ['POST', 'GET'])]
    public function newPeriode(Request $request): Response
    {
        $newPeriode = new Periode();
        $form = $this->createForm(PeriodeFormType::class, $newPeriode);
        $form->handleRequest($request);

        if ($request->getMethod() == 'GET') {
            $form->get('date_debut')->setData(new DateTime('now',  new DateTimeZone('Europe/Paris')));
            $form->get('date_fin')->setData(new DateTime('now',  new DateTimeZone('Europe/Paris')));
        }

        if ($form->isSubmitted() && $form->isValid()){
            $newPeriode = $form->getData();

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($newPeriode);
            $entityManager->flush();
            $this->addFlash('success', 'La période a été enregistré avec succès !');
        }

        return $this->render('periode/newPeriode.html.twig',
            ['periodeForm' => $form->createView(),
                'title' => "Création d'un periode",
                'periode' => $newPeriode,
                'action' => 'Créer'
        ]);
    }

    /**
     * @Route("/periode/edit/{id}", name="periode_edit")
     */
    public function editPeriode(Request $request, UserPasswordHasherInterface $userPasswordHasher, $id): Response
    {
        $periode = $this->doctrine->getRepository(Periode::class)->find($id);

        $form = $this->createForm(PeriodeFormType::class, $periode);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $periode = $form->getData();

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($periode);
            $entityManager->flush();
            $this->addFlash('success', 'La période a été modifiée avec succès !');
        }

        return $this->render('periode/newPeriode.html.twig',
            ['periodeForm' => $form->createView(),
             'title' => "Création d'un periode",
             'periode' => $periode,
             'action' => 'Modifier'
            ]);
    }

    /**
     * @Route("/periode/list", name="periode_list")
     * @param Request $request
     *
     * @return Response
     */
    public function periodes(Request $request): Response
    {
        $periodes = $this->doctrine->getRepository(Periode::class)->findAll();

        return $this->render('periode/listingPeriode.html.twig', [
            'periodes' => $periodes,
            'title' => 'Liste des periodes'
        ]);

    }

    /**
     * @Route("/periode/delete/{id}", name="periode_delete")
     */
    public function deletePeriode(Request $request, $id)
    {
        $entityManager = $this->doctrine->getManager();
        $entity = $entityManager->getRepository(Periode::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Periode entity.');
        }
        $entityManager->remove($entity);
        $entityManager->flush();
        return $this->redirectToRoute('periode_list');

    }

}