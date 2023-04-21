<?php

namespace App\Controller;

use App\Entity\CommentaireCours;
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
    /**
     * @Route("/event/{id}/comment", name="event_comment_create", methods={"POST"})
     */
    public function create(Request $request, $id): JsonResponse
    {
        $commentaire = $this->doctrine->getRepository(CommentaireCourRepository::class)->find($id);

        $form = $this->createForm(CommentaireCoursType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // save the comment to the database
            $commentaire->status = 0;
            return new JsonResponse([
                'success' => true,
                'message' => 'Comment created successfully.',
            ]);
        }

        // if the form is not valid, return the form errors
        $errors = $this->getFormErrors($form);

        return new JsonResponse([
            'success' => false,
            'errors' => $errors,
        ]);
    }

    private function getFormErrors($form): array
    {
        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if (!$childForm->isValid()) {
                $errors[$childForm->getName()] = $this->getFormErrors($childForm);
            }
        }

        return $errors;
    }

    public function addComment(Request $request, int $eventId)
    {
        $event = $this->doctrine->getRepository(CommentaireCourRepository::class)->find($eventId);
        if (!$event) {
            throw $this->createNotFoundException('Event not found');
        }

        $comment = new CommentaireCours();
        $comment->setCours($event);

        $form = $this->createForm(CommentaireCours::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_calendar_index');
        }

        return $this->render('admin.html.twig', [
            'form' => $form->createView(),
            'eventId' => $eventId,
        ]);
    }
}