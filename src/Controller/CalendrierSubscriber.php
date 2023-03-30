<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Repository\CoursRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
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

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        $cours = $this->coursRepository
            ->createQueryBuilder('cours')
            ->where('cours.date_debut BETWEEN :start and :end OR cours.date_fin BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;
        
        foreach ($cours as $cour) {
            // this create the events with your data (here booking data) to fill calendar
            $coursEvent = new Event(
                $cour->getNom(),
                $cour->getDateDebut(),
                $cour->getDateFin() // If the end date is null or not defined, a all day event is created.
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
                $this->router->generate('app_cours_show', [
                    'id' => $cour->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($coursEvent);
        }
    }
}