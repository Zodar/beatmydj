<?php
namespace BmdUserBundle\Controller;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Comment;
use BmdUserBundle\Entity\UserAvailability;
use \DateTime;
use \DateInterval;

class ProfilController extends Controller
{

    /**
     *
     * @Route("/profil/userEvent", name="user_event")
     * @Method("Post")
     *
     * @param Request $request            
     */
    public function loadCalendarAction(Request $request)
    {
        $startDatetime = new \DateTime();
        $startDatetime->setTimestamp(strtotime($request->get('start')));
        
        $endDatetime = new \DateTime();
        $endDatetime->setTimestamp(strtotime($request->get('end')));
        
//         $events = $this->container->get('event_dispatcher')
//             ->dispatch(CalendarEvent::CONFIGURE, new CalendarEvent($startDatetime, $endDatetime, $request))
//             ->getEvents();
        
        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');
        
        $return_events = array();
        $events = $this->getDoctrine()
            ->getManager()
            ->getRepository('BmdUserBundle:UserAvailability')
            ->createQueryBuilder('ua')
            ->where('ua.dateStart >= :startDate')
            ->andWhere('ua.dateEnd <= :endDate')
            ->andWhere('ua.accept = 1')
            ->setParameter('startDate', $startDatetime->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDatetime->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();
        
        foreach ($events as $event) {
            $return_events[] = $event->toArray();
        }
        
        $response->setContent(json_encode($return_events));
        return $response;
    }

    /**
     *
     * @Route("/video", name="video")
     * @Method("GET")
     *
     * @param Request $request            
     */
    public function VideoAction(Request $request)
    {
        $filename = "C:\\Users\\ohandoura\\ETNA\\PROJET-ETNA\\GPE\\beatmydj\\web\\uploads\\videos\\Wildlife.wmv";
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        return new Response($contents, 200, array(
            'Content-Type' => 'video/wmv'
        ));
    }

    /**
     *
     * @Route("/profil/add_event", name="ajout_evenement")
     * @Method("POST")
     *
     * @param Request $request            
     */
    public function AddEventAction(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $duree = $this->get('request')->get('duree') != null ? $this->get('request')->get('duree') : "1";
            $timestamp = $this->get('request')->get('date') / 1000;
            $date = new DateTime();
            $date->setTimestamp($timestamp);
            $dateend = clone $date;
            $dateend->add(new DateInterval("PT{$duree}H"));
            $date->setTimestamp($timestamp);
            $uid = $this->get('request')->get('user');
            if ($this->checkEventAvailable($date, $dateend, $uid) == false)
                return new JsonResponse(array(
                    'success' => "false",
                    "info" => "Un evenement a lieu pendant cette periode"
                ));
            $usr = $this->get('security.token_storage')
                ->getToken()
                ->getUser();
            
            $event = new UserAvailability();
            $event->setauteur($usr->getUsername());
            $event->setuserid($uid);
            
            $event->setdatestart($date);
            $event->setdateend($dateend);
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            return new JsonResponse(array(
                'success' => "true"
            ));
        } else {
            return new JsonResponse(array(
                'success' => "false"
            ));
        }
    }

    private function checkEventAvailable($datestart, $dateend, $userid)
    {
        $Events = $this->getDoctrine()
            ->getManager()
            ->getRepository('BmdUserBundle:UserAvailability')
            ->createQueryBuilder('e')
            ->where('e.dateStart <= :startDate AND e.dateEnd >= :startDate AND e.userid = :userId')
            ->setParameter('startDate', $datestart->format('Y-m-d H:i:s'))
            ->setParameter('userId', $userid)
            ->getQuery()
            ->getResult();
        
        if (! empty($Events))
            return false;
        $Events = $this->getDoctrine()
            ->getManager()
            ->getRepository('BmdUserBundle:UserAvailability')
            ->createQueryBuilder('e')
            ->where('e.dateEnd >= :endDate AND e.dateStart <= :endDate AND e.userid = :userId')
            ->setParameter('endDate', $dateend->format('Y-m-d H:i:s'))
            ->setParameter('userId', $userid)
            ->getQuery()
            ->getResult();
        if (! empty($Events))
            return false;
        
        return true;
    }

    /**
     *
     * @Route("/profil/edit", name="edit_profil_POST")
     * @Method("POST")
     *
     * @param Request $request            
     */
    public function EditProfilActionPOST(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            
            $usr = $this->get('security.token_storage')
                ->getToken()
                ->getUser();
            
            if ($this->get('request')->get('name') != null) {
                if ($this->get('request')->get('name') == "userFirstName") {
                    $usr->setfirstname($this->get('request')
                        ->get('value'));
                } else 
                    if ($this->get('request')->get('name') == "userLastName") {
                        $usr->setlastname($this->get('request')
                            ->get('value'));
                    } else 
                        if ($this->get('request')->get('name') == "userLocation") {
                            $usr->setLocation($this->get('request')
                                ->get('value'));
                        } else 
                            if ($this->get('request')->get('name') == "userEmail") {
                                $usr->setEmail($this->get('request')
                                    ->get('value'));
                            } else 
                                if ($this->get('request')->get('name') == "tarif") {
                                    $usr->setTarif($this->get('request')
                                        ->get('value'));
                                } else 
                                    if ($this->get('request')->get('name') == "style") {
                                        $usr->setStyle($this->get('request')
                                            ->get('value'));
                                    } else 
                                        if ($this->get('request')->get('name') == "userPresentation") {
                                            $usr->setPresentation($this->get('request')
                                                ->get('value'));
                                        } else 
                                            if ($this->get('request')->get('name') == "changePlaylist") {
                                                $usr->setSoundCloodLink($this->get('request')
                                                    ->get('value'));
                                            }
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($usr);
            $em->flush();
            return new JsonResponse(array(
                'success' => "true"
            ));
        } else {
            return new JsonResponse(array(
                'success' => "false"
            ));
        }
    }

    /**
     *
     * @Route("/profil/remove", name="remove_POST")
     * @Method("POST")
     *
     * @param Request $request            
     */
    public function RemoveProfllActionPOST(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $usr = $this->get('security.token_storage')
                ->getToken()
                ->getUser();
            
            $em = $this->getDoctrine()->getManager();
            $em->remove($usr);
            $em->flush();
            
            $this->get('security.context')->setToken(null);
            $this->get('request')
                ->getSession()
                ->invalidate();
            
            return new JsonResponse(array(
                'success' => "true"
            ));
        }
        return new JsonResponse(array(
            'success' => "false"
        ));
    }

    /**
     *
     * @Route("/profil/addcomment", name="comment_POST")
     * @Method("POST")
     *
     * @param Request $request            
     */
    public function AddCommentProfllActionPOST(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $usr = $this->get('security.token_storage')
                ->getToken()
                ->getUser();
            
            $comment = new Comment();
            
            $comment->content = $this->get('request')->get('content');
            $comment->userpage = $this->get('request')->get('userpage');
            $comment->response = $this->get('request')->get('response');
            $comment->userid = $usr->getId();
            
            $comment->pseudo = $usr->getUsername();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return new JsonResponse(array(
                'success' => "true"
            ));
        }
        return new JsonResponse(array(
            'success' => "false"
        ));
    }

    /**
     *
     * @Route("/profil/edit/picture", name="edit_profil_image_POST")
     * @Method("POST")
     *
     * @param Request $request            
     */
    public function EditProfilImageActionPOST(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $usr = $this->get('security.token_storage')
                ->getToken()
                ->getUser();
            
            $usr->setFile($request->files->get('photo')); // here you have get your file field name
            
            $usr->preUpload();
            $usr->upload();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($usr);
            $em->flush();
            
            return new JsonResponse(array(
                'success' => "true"
            ));
        } else
            return $this->redirect($this->generateUrl('homepage'));
    }
}
?>