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
use \Experience;

class ProfilController extends Controller
{

    /**
     * Récupere les evenement du calendrier
     * @Route("/profil/userEvent", name="user_event")
     *
     * @method ("Post")
     *        
     * @param Request $request
     */
    public function loadCalendarAction(Request $request)
    {
        /* Préparation de la fourchette de date */
        $startDatetime = new \DateTime();
        $startDatetime->setTimestamp(strtotime($request->get('start')));
        
        $endDatetime = new \DateTime();
        $endDatetime->setTimestamp(strtotime($request->get('end')));
        
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
     * Ajout d'évenement
     * @Route("/profil/add_event", name="ajout_evenement")
     *
     * @method ("POST")
     *        
     * @param Request $request
     */
    public function AddEventAction(Request $request)
    {
        /* Si l'utilisateur est connecté */
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            
            /* Préparation de l'entitié event et test de l'existance d'un évenelebt sur cette periode */
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

    /* Test si un évenement existe aprés la date de début et avant la date de fin */
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
     * Page appelé quand l'utilisateur modifie son profils
     * @Route("/profil/edit", name="edit_profil_POST")
     *
     * @method ("POST")
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
                } else if ($this->get('request')->get('name') == "userLastName") {
                    $usr->setlastname($this->get('request')
                        ->get('value'));
                } else if ($this->get('request')->get('name') == "userLocation") {
                    $usr->setLocation($this->get('request')
                        ->get('value'));
                } else if ($this->get('request')->get('name') == "userEmail") {
                    $usr->setEmail($this->get('request')
                        ->get('value'));
                } else if ($this->get('request')->get('name') == "tarif") {
                    $usr->setTarif($this->get('request')
                        ->get('value'));
                } else if ($this->get('request')->get('name') == "style") {
                    $usr->setStyle($this->get('request')
                        ->get('value'));
                } else if ($this->get('request')->get('name') == "userPresentation") {
                    $usr->setPresentation($this->get('request')
                        ->get('value'));
                } else if ($this->get('request')->get('name') == "changePlaylist") {
                    $usr->setSoundCloodLink($this->get('request')
                        ->get('value'));
                } else if ($this->get('request')->get('name') == "infos") {
                    $form = $this->get('request')->get('value');
                    if (strlen($form["lastname"]) > 0)
                        $usr->setlastname($form["lastname"]);
                    if (strlen($form["firstname"]) > 0)
                        $usr->setfirstname($form["firstname"]);
                    if (strlen($form["password"]) > 6) {
                        $password = $this->get('security.password_encoder')->encodePassword($user, $form["password"]);
                        $usr->setPassword($password);
                    }
                } else if ($this->get('request')->get('name') == "experience") {
                    $value = $this->get('request')->get('value');
                    $usr->setExperience($this->get('request')
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
     * Page appélé quand l'utilisateur supprime son profil
     * @Route("/profil/remove", name="remove_POST")
     *
     * @method ("POST")
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
     * Ajout d'un commentaires
     * @Route("/profil/addcomment", name="comment_POST")
     *
     * @method ("POST")
     *        
     * @param Request $request
     */
    public function AddCommentProfllActionPOST(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $usr = $this->get('security.token_storage')
                ->getToken()
                ->getUser();
            
            /* Préparation de l'entité */
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
     * Changement de l'image
     * @Route("/profil/edit/picture", name="edit_profil_image_POST")
     *
     * @method ("POST")
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