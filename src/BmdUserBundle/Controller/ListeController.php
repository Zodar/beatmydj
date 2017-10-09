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
     *
     * @method ("GET")
     *        
     * @param Request $request
     */
    public function DJ_listing(Request $request)
    {
        $all = $this->getallDJ();
        $datas = $all["user"];
        $listeStyle = $all["style"];
        
        return $this->render('home/liste_dj.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            'users' => $datas,
            'listeStyle' => $listeStyle
        ));
    }

    public function getallDJ()
    {
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
        
        return Array(
            "user" => $datas,
            "style" => $pseudo[0]->getAllStyleText()
        );
    }

    /**
     *
     * @Route("/get_all_dj",options={"expose"=true}, name="getAllUser")
     *
     * @method ("GET")
     *        
     * @param Request $request
     */
    public function getAllUser(Request $request)
    {
        $datas = $this->getallDJ();
        
        return new JsonResponse(array(
            'users' => $datas,
            'value' => "ok"
        ));
    }

    /**
     *
     * @Route("/getFiltredDj",options={"expose"=true}, name="getFiltredDj")
     *
     * @method ("POST")
     *        
     * @param Request $request
     */
    public function getFiltredDj(Request $request)
    {
        $find = $this->getDoctrine()->getRepository('AppBundle:User');
        
        /* Récuperation de le requete */
        $style = $this->get('request')->get('style');
        $experience =  $this->get('request')->get('experience');
        $prix =  $this->get('request')->get('prix');
        
        if ($experience == null)
            $experience = 0;
        
        /* */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Style')->createQueryBuilder('s');
        $orX = $qb->expr()->orX();
        $value = false;
        foreach ($style as $value) {
            $orX->add("s." . $value . " = 1");
            $value = true;
        }
        if ($value == true) {
            $qb->select('s.idUser')->where($orX);
            $matches_reply = $qb->getQuery()->getResult();
            $id = array();
            foreach ($matches_reply as $dj) {
                $id[] = $dj["idUser"];
            }
        } else {
            $findDjRole = $this->getDoctrine()->getRepository('AppBundle:RoleAssociative');
            $djs = $findDjRole->findBy(array(
                "idRole" => 3
            ));
            $id = array();
            foreach ($djs as $dj) {
                $id[] = $dj->getidUser();
            }
        }
        
        if (empty($id))
            return new JsonResponse(array(
                'users' => Array(),
                'value' => "ok"
            ));
        /* */
        $qb = $this->getDoctrine()->getRepository('AppBundle:User')->createQueryBuilder('u');;
        $qb->select('u');
        $qb->add('where', $qb->expr()->in('u.id',$id));
        $qb->andWhere("u.pph >= " .$prix[0] );
        $qb->andWhere("u.pph <= " .$prix[1] );
        if ($experience != null && $experience > 0 )
        $qb->andWhere("u.experience = " .$experience );
        
        $pseudo = $qb->getQuery()->getResult();
     
        $datas = [];
        /* @TODO ce code apparait partout A FACTORISE !!! (faire une methode toString dans l'entité user */
        
        foreach ($pseudo as $user) {
            array_push($datas, $user->toArray());
        }
        
        return new JsonResponse(array(
            'users' => $datas,
            'value' => "ok"
        ));
    }

    /**
     *
     * @todo C'est vraiment moche header en dur commentaires a changgeeeeeeer
     *       @Route("/get_all_dj", name="getAllDjMobile")
     * @method ("GET")
     *        
     * @param Request $request
     */
    public function getAllDjMobile(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $usr = null;
        // if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
        // $usr = $this->get('security.token_storage')
        // ->getToken()
        // ->getUser();
        // }
        $users = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findAll();
        $datas = [];
        
        foreach ($users as $user) {
            // if ($usr->getId() != $user->getId()) {
            array_push($datas, $user->toArray());
            
            // }
        }
        $r = new JsonResponse(array(
            'users' => $datas,
            'value' => "ok"
        ));
        
        $r->getStatusCode(200);
        return $r;
    }

    /**
     * Récuperations des utilisateurs en lignes
     * @Route("/getOnlinedj",options={"expose"=true}, name="getOnlineUser")
     *
     * @method ("GET")
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
        } else
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
        
        $qb = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->createQueryBuilder('u')
            ->where('u.lastActivity > :delay')
            ->setParameter('delay', $delay);
        
        return $qb->getQuery()->getResult();
    }

    /**
     *
     * @Route("/dj",options={"expose"=true}, name="getOneUserById")
     *
     * @method ("GET")
     * @todo Virér se header en duuuuuuuuur
     * @param Request $request
     */
    public function getOneUserById(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->createQueryBuilder('u')
            ->where('u.id = $id');
        
        return new JsonResponse(array(
            'users' => $user,
            'value' => "ok"
        ));
    }
}