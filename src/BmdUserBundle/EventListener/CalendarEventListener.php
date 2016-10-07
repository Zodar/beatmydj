<?php

namespace BmdUserBundle\EventListener;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use Doctrine\ORM\EntityManager;
use \DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CalendarEventListener extends Controller
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();

        // The original request so you can get filters from the calendar
        // Use the filter in your query for example

        $request = $calendarEvent->getRequest();
        $filter = $request->get('filter');
        $userid = $request->get('userid');

        // load events using your custom logic here,
        // for instance, retrieving events from a repository

//         $companyEvents = $this->entityManager->getRepository('AcmeDemoBundle:MyCompanyEvents')
//         ->createQueryBuilder('company_events')
//         ->where('company_events.event_datetime BETWEEN :startDate and :endDate')
//         ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
//         ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
//         ->getQuery()->getResult();

        
        $Events = $this->entityManager->getRepository('BmdUserBundle:UserAvailability')
        ->createQueryBuilder('e')
        ->where('e.dateStart > :startDate AND e.userid = :userId')
        ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
        ->setParameter('userId', $userid)
        ->getQuery()->getResult();


        foreach($Events as $Event) {
            // create an event with a start/end time, or an all day event
//             if ($Event->getAllDayEvent() === false) {
            $eventEntity = new EventEntity("Live pour ".$Event->getAuteur(), $Event->getdateStart(), $Event->getdateEnd());
//             } else {
//                 $eventEntity = new EventEntity($companyEvent->getTitle(), $Event->getdateStart(), null, true);
//             }

            //optional calendar event settings
            $eventEntity->setAllDay(false); // default is false, set to true if this is an all day event
            $eventEntity->setBgColor('#FF0000'); //set the background color of the event's label
            $eventEntity->setFgColor('#FFFFFF'); //set the foreground color of the event's label
            $eventEntity->setUrl('#'); // url to send user to when event label is clicked
            $eventEntity->setCssClass('my-custom-class'); // a custom class you may want to apply to event labels

            //finally, add the event to the CalendarEvent for displaying on the calendar
            $calendarEvent->addEvent($eventEntity);
        }
    }
}
