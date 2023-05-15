<?php

namespace App\Controller;

use App\Entity\Intervenant;
use App\Entity\User;
use App\Form\IntervenantFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/admin')]
class IntervenantController extends AbstractController
{
    public ManagerRegistry $doctrine;

    function __construct( ManagerRegistry $doctrine ){
        $this->doctrine = $doctrine ;
    }

    #[Route("/intervenant/new", name: 'intervenant_new', methods: ['POST', 'GET'])]
    public function newIntervenant(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $newIntervenant = new Intervenant();
        $form = $this->createForm(IntervenantFormType::class, $newIntervenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newIntervenant = $form->getData();

            $user = new User();
            $user->setCivilite($form['civilite']->getData());
            $user->setNom($form['nom']->getData());
            $user->setPrenom($form['prenom']->getData());
            $user->setEmail($form['email']->getData());
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form['password']->getData()
                )
            );
            $newIntervenant->setUser($user);

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($newIntervenant);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'L\'intervenant '. $user->getNom().' '.$user->getPrenom().' et son compte utilisateur ont bien été enregistrés !');
        }

        return $this->render('intervenant/newIntervenant.html.twig',
            ['intervenantForm' => $form->createView(),
                'title' => "Création d'un intervenant",
                'intervenant' => $newIntervenant,
                'action' => 'Créer'
        ]);
    }

    /**
     * @Route("/intervenant/edit/{id}", name="intervenant_edit")
     */
    public function editIntervenant(Request $request, UserPasswordHasherInterface $userPasswordHasher, $id): Response
    {
        $intervenant = $this->doctrine->getRepository(Intervenant::class)->find($id);

        $form = $this->createForm(IntervenantFormType::class, $intervenant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $intervenant = $form->getData();

            $user = $intervenant->getUser();
            $user->setCivilite($form['civilite']->getData());
            $user->setNom($form['nom']->getData());
            $user->setPrenom($form['prenom']->getData());
            $user->setEmail($form['email']->getData());

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form['password']->getData()
                )
            );

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($intervenant);
            $entityManager->flush();
            $this->addFlash('success', 'L\'intervenant '.$intervenant->getNom().' '.$intervenant->getPrenom().' à été modifié avec succés');
        }

        return $this->render('intervenant/newIntervenant.html.twig',
            ['intervenantForm' => $form->createView(),
             'title' => "Création d'un intervenant",
             'intervenant' => $intervenant,
             'action' => 'Modifier'
            ]);
    }

    /**
     * @Route("/intervenant/list", name="intervenant_list")
     * @param Request $request
     *
     * @return Response
     */
    public function intervenants(Request $request): Response
    {
        $intervenants = $this->doctrine->getRepository(Intervenant::class)->findAll();

        return $this->render('intervenant/listingIntervenant.html.twig', [
            'intervenants' => $intervenants,
            'title' => 'Liste des intervenants'
        ]);

    }

    /**
     * @Route("/intervenant/delete/{id}", name="intervenant_delete")
     */
    public function deleteIntervenant(Request $request, $id): RedirectResponse
    {
        $entityManager = $this->doctrine->getManager();
        $entity = $entityManager->getRepository(Intervenant::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intervenant entity.');
        }
        $entityManager->remove($entity);
        $entityManager->flush();
        return $this->redirectToRoute('intervenant_list');

    }

}