<?php
namespace BmdUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Comment;
use Doctrine\ORM\Query;

class ListeController extends Controller
{

    /**
     * Récupera les utilisateur qui sont des djs
     * @Route("/liste_dj", name="liste_dj")
     * @Method("GET")
     *
     * @param Request $request            
     */
    public function DJ_listing(Request $request)
    {
		/* @TODO Actuellement il y a deux requete voir si possible d'en faire qu'une seul */
        $find = $this->getDoctrine()->getRepository('AppBundle:User');
        $findDjRole = $this->getDoctrine()->getRepository('AppBundle:RoleAssociative');
        $djs = $findDjRole->findBy(array(
            "idRole" => 3
        ));
        $id = array();
        foreach ($djs as $dj) {
            $id[] = $dj->getidUser();
        }
        $pseudo = $find->findBy(array(
            "id" => $id
        ));
        $datas = [];
        foreach ($pseudo as $user) {
        	array_push($datas, $user->toArray());
        }
        
        $listeStyle = $user->getAllStyleText();

        return $this->render('home/liste_dj.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            'users' => $datas,
            'listeStyle' => $listeStyle
        ));
    }

    /**
     *
     * @Route("/get_all_dj",options={"expose"=true}, name="getAllUser")
     * @Method("GET")
     *
     * @param Request $request            
     */
    public function getAllUser(Request $request)
    {
        $usr = null;
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $usr = $this->get('security.token_storage')
                ->getToken()
                ->getUser();
        }
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        $datas = [];
        
        foreach ($users as $user) {
        	array_push($datas, $user->toArray());
        }
        
        return new JsonResponse(array(
            'users' => $datas,
            'value' => "ok"
        ));
    }

    /**
     * @TODO C'est vraiment moche header en dur commentaires a changgeeeeeeer 
     * @Route("/get_all_dj", name="getAllDjMobile")
     * @Method("GET")
     *
     * @param Request $request            
     */
    public function getAllDjMobile(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $usr = null;
        // if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
        //     $usr = $this->get('security.token_storage')
        //         ->getToken()
        //         ->getUser();
        // }
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        $datas = [];
       

        foreach ($users as $user) {
           // if ($usr->getId() != $user->getId()) {
        	array_push($datas, $user->toArray());
        	
           // }
        }
        $r = new JsonResponse(array(
            'users' => $datas,
            'value' => "ok" ));

            $r->getStatusCode(200);
        return $r;
    }
    
    /**
     * Récuperations des utilisateurs en lignes
     * @Route("/getOnlinedj",options={"expose"=true}, name="getOnlineUser")
     * @Method("GET")
     *
     * @param Request $request
     */
    public function getOnlineUser(Request $request)
    {
        $usr = null;
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $usr = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        }
        else 
            return new JsonResponse(array(
                'users' => null,
                'value' => "ok"
            ));
			
			$users = $this->getActive();
        $datas = [];
    
        foreach ($users as $user) {
            if ($usr->getId() != $user->getId()) {
            	array_push($datas, $user->toArray());
            }
        }
    
        return new JsonResponse(array(
            'users' => $datas,
            'value' => "ok"
        ));
    }
    
	/* Récupere les utilisateur ayant fais une action il y a moins de 5 minutes */
    public function getActive()
    {
        $delay = new \DateTime();
        $delay->setTimestamp(strtotime('5 minutes ago'));
    
        $qb = $this->getDoctrine()->getRepository('AppBundle:User')->createQueryBuilder('u')
        ->where('u.lastActivity > :delay')
        ->setParameter('delay', $delay);
    
        return $qb->getQuery()->getResult();
    }

    /**
     *
     * @Route("/dj",options={"expose"=true}, name="getOneUserById")
     * @Method("GET")
     * @TODO Virér se header en duuuuuuuuur 
     * @param Request $request            
     */ 
    public function getOneUserById(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->createQueryBuilder('u')->where('u.id = $id');
       
        return new JsonResponse(array(
            'users' => $user,
            'value' => "ok" ));

    }
}