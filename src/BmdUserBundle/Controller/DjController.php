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

class DjController extends Controller{

    /**
     * @TODO a commenté 
     * @Route("/DjPanel/streams",options={"expose"=true}, name="djPanel_streams")
     * @Method("GET")
     *
     * @param Request $request
     */
    public function DjPanelsStreams(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){
            $usr = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
            $find = $this->getDoctrine()->getRepository('BmdUserBundle:UserAvailability');
            $events =  $find->findBy(array(
                "userid" =>  $usr->getId(),
                "accept" => null
            ));
            
            $datas = [];
            
            foreach ($events as $event) {
                $data = [];
                $data["id"] = $event->getId();
                $data["auteur"] = $event->getAuteur();
                $data["dateStart"] = $event->getdateStart();
                $data["dateEnd"] = $event->getdateEnd();
                array_push($datas, $data);
            }
            return new JsonResponse(array(
                'streams' => $datas
            ));
        }
        else
            return $this->redirect($this->generateUrl('homepage'));
    }
    
    /**
     * Action lorsque le DJ accepte le stream
     * @Route("/DjPanel/acceptStreams",options={"expose"=true}, name="djPanel_acceptstreams")
     * @Method("POST")
     *
     * @param Request $request
     */
    public function AcceptsStreamAction(Request $request)
    {
		/* Si l'utilisateur connecté 
			@TODO verifié que l'évenement qui va etre accepté est bien lié a l'utilisateur courant
		*/
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){
            $usr = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
            $eventids = $this->get('request')->get('ids');
            
            $repo = $this->getDoctrine()->getRepository('BmdUserBundle:UserAvailability');
            
            $qb = $repo->createQueryBuilder('e');
            $qb->update()
                ->set('e.accept', 'true')
                ->where('e.id IN (:ids)')
                ->setParameter('ids', array_values($eventids));
            $qb->getQuery()->execute();
 
            $usr->setNbevents($usr->getNbevents() + count($eventids));
            
            $em = $this->getDoctrine ()->getManager ();
            $em->persist ( $usr );
            $em->flush ();
            
            return new JsonResponse(array(
                'info' => "Les Evenements ont bien été accépté",
            ));
        }
        else
            return $this->redirect($this->generateUrl('homepage'));
    }
    

    /**
     *
     * @Route("/DjPanel/refuseStream",options={"expose"=true}, name="djPanel_refusestreams")
     * @Method("POST")
     *
     * @param Request $request
     */
    public function RefuseStreamAction(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){
            $usr = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
            $eventids = $this->get('request')->get('ids');
    
            $repo = $this->getDoctrine()->getRepository('BmdUserBundle:UserAvailability');
    
            $qb = $repo->createQueryBuilder('e');
            $qb->update()
            ->set('e.accept', 'false')
            ->where('e.id = :ids')
            ->setParameter('ids', $eventids);
            $qb->getQuery()->execute();
    
            return new JsonResponse(array(
                'info' => "Les Evenements ont bien été refusé",
            ));
        }
        else
            return $this->redirect($this->generateUrl('homepage'));
    }
    
    /**
     *
     * @Route("/DjPanel/views",options={"expose"=true}, name="djpanel_view")
     * @Method("GET")
     *
     * @param Request $request
     */
    public function GetViewsAction(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){
            $usr = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
           
            
            $clientviews = $this->getDoctrine()->getRepository('BmdUserBundle:ClientView');
           
            $views = $clientviews->findBy(array(
                "visited" => $usr->getId()
            ));
            
            $datas = [];
            
            foreach ($views as $v) {
                $data = [];
                $data["userName"] = $v->getClient();
                $data["date"] = $v->getDate();
                array_push($datas, $data);
            }
            return new JsonResponse(array(
                'views' => $datas
            ));
        }
        else
            return $this->redirect($this->generateUrl('homepage'));
    }
}