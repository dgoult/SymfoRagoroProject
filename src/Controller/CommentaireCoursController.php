<?php

namespace App\Controller;

use App\Entity\CommentaireCours;
use App\Entity\Cours;
use App\Form\CommentaireCoursType;
use App\Repository\CommentaireCourRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentaireCoursController extends AbstractController
{

    public ManagerRegistry $doctrine;

    function __construct( ManagerRegistry $doctrine ){
        $this->doctrine = $doctrine ;
    }

    #[Route('/cours/{id}/comment', name: 'cours_create_commentaire', methods: ['GET','POST'])]
    public function create(CommentaireCourRepository $repository, Request $request, UserInterface $user, $id): JsonResponse
    {
        // En GET, on retourne la liste des commentaire du cours
        if ($request->getMethod() == 'GET') {
            $comments = $repository->findCommentaireByCoursId($id);
            $commentsJson = [];
            foreach ($comments as $comment) {
                $commentsJson[] = json_encode($comment);
            }
            return new JsonResponse([
                'comments' => $commentsJson
            ]);
        }

        $event = $this->doctrine->getRepository(Cours::class)->find($id);

        $comment = New CommentaireCours();
        $form = $this->createForm(CommentaireCoursType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment = $form->getData();
            $comment->setCours($event);
            $comment->setStatus(0);
            $comment->setDateCreation(new DateTime());
            $comment->setAuthor($user);

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Comment created successfully.',
            ]);
        }
        return new JsonResponse([
            'success' => false,
        ]);
    }

//    private function getFormErrors($form): array
//    {
//        $errors = [];
//
//        foreach ($form->getErrors(true) as $error) {
//            $errors[] = $error->getMessage();
//        }
//
//        foreach ($form->all() as $childForm) {
//            if (!$childForm->isValid()) {
//                $errors[$childForm->getName()] = $this->getFormErrors($childForm);
//            }
//        }
//
//        return $errors;
//    }
}