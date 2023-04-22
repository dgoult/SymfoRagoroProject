<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Repository\CoursRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendrierSubscriber implements EventSubscriberInterface
{

    private CoursRepository $coursRepository;
    private UrlGeneratorInterface $router;

    public function __construct(
        CoursRepository $coursRepository,
        UrlGeneratorInterface $router
    ) {
        $this->coursRepository = $coursRepository;
        $this->router = $router;
    }
    
    #[ArrayShape([CalendarEvents::SET_DATA => "string"])] public static function getSubscribedEvents(): array
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    /**
     * @throws \Exception
     */
    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();


        $cours = $this->coursRepository
            ->createQueryBuilder('cours')
            ->where('(cours.date_cours = :start_date AND cours.heure_fin > :start_time) OR (cours.date_cours = :end_date AND cours.heure_debut < :end_time) OR (cours.date_cours > :start_date AND cours.date_cours < :end_date)')
            ->setParameter('start_date', $start->format('Y-m-d'))
            ->setParameter('start_time', $start->format('H:i:s'))
            ->setParameter('end_date', $end->format('Y-m-d'))
            ->setParameter('end_time', $end->format('H:i:s'))
            ->getQuery()
            ->getResult();
        
        foreach ($cours as $cour) {
            // this create the events with your data (here booking data) to fill calendar
            $coursEvent = new Event(
                $cour->getNom(),
                new DateTime($cour->getDateCours()->format('Y-m-d') . ' ' . $cour->getHeureDebut()->format('H:i:s')),
                new DateTime($cour->getDateCours()->format('Y-m-d') . ' ' . $cour->getHeureFin()->format('H:i:s'))// If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $coursEvent->setOptions([
                'backgroundColor' => $cour->getMatiere()->getCouleurCalendrier(),
                'borderColor' => 'black',
            ]);
            $coursEvent->addOption(
                'url',
                $this->router->generate('cours_create_commentaire', [
                    'id' => $cour->getId(),
                ])
            );
            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($coursEvent);
        }
    }
}