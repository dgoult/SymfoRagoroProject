<?php

namespace App\Controller;

use App\Entity\CommentaireCours;
use App\Entity\Cours;
use App\Form\CommentaireCoursType;
use App\Repository\CommentaireCourRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireCoursController extends AbstractController
{

    public ManagerRegistry $doctrine;

    function __construct( ManagerRegistry $doctrine ){
        $this->doctrine = $doctrine ;
    }

    #[Route('/cours/{id}/comment', name: 'cours_create_commentaire', methods: ['POST'])]
    public function create(CommentaireCourRepository $repository, Request $request, $id): JsonResponse
    {
        $event = $this->doctrine->getRepository(Cours::class)->find($id);

        $form = $this->createForm(CommentaireCoursType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setCours($event);
            $comment->setStatus(0);
            $repository->save($comment);

            return new JsonResponse([
                'success' => true,
                'message' => 'Comment created successfully.',
            ]);
        }

//        $errors = $this->getFormErrors($form);

        return new JsonResponse([
            'success' => false,
//            'errors' => $errors,
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