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
     *
     * @Route("/liste_dj", name="liste_dj")
     * @Method("GET")
     *
     * @param Request $request            
     */
    public function DJ_listing(Request $request)
    {
        $find = $this->getDoctrine()->getRepository('AppBundle:User');
        $finduser = $this->getDoctrine()->getRepository('AppBundle:User');
        $findDjRole = $this->getDoctrine()->getRepository('AppBundle:RoleAssociative');
        // $users = $find->findAll(Query::HYDRATE_ARRAY);
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
            $data = [];
            $data["id"] = $user->getId();
            $data["email"] = $user->getEmail();
            $data["firstName"] = $user->getFirstName();
            $data["lastName"] = $user->getLastName();
            $data["userName"] = $user->getUserName();
            $data["presentation"] = $user->getPresentation();
            $data["style"] = $user->getStyle();
            $data["dispo"] = $user->getDispo();
            $data["path"] = $user->path;
            array_push($datas, $data);
        }
        
        return $this->render('home/liste_dj.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            'users' => $datas
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
            if ($usr->getId() != $user->getId()) {
                $data = [];
                $data["id"] = $user->getId();
                $data["email"] = $user->getEmail();
                $data["firstName"] = $user->getFirstName();
                $data["lastName"] = $user->getLastName();
                $data["userName"] = $user->getUserName();
                $data["presentation"] = $user->getPresentation();
                $data["style"] = $user->getStyle();
                $data["dispo"] = $user->getDispo();
                $data["path"] = $user->path;
                array_push($datas, $data);
            }
        }
        
        return new JsonResponse(array(
            'users' => $datas,
            'value' => "ok"
        ));
    }
    
    /**
     *
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
        //         $find = $this->getDoctrine()->getRepository('AppBundle:User');
        $users = $this->getActive();
        $datas = [];
    
        foreach ($users as $user) {
            if ($usr->getId() != $user->getId()) {
                $data = [];
                $data["id"] = $user->getId();
                $data["email"] = $user->getEmail();
                $data["firstName"] = $user->getFirstName();
                $data["lastName"] = $user->getLastName();
                $data["userName"] = $user->getUserName();
                $data["presentation"] = $user->getPresentation();
                $data["style"] = $user->getStyle();
                $data["dispo"] = $user->getDispo();
                $data["path"] = $user->path;
                array_push($datas, $data);
            }
        }
    
        return new JsonResponse(array(
            'users' => $datas,
            'value' => "ok"
        ));
    }
    
    public function getActive()
    {
        // Comme vous le voyez, le délais est redondant ici, l'idéale serait de le rendre configurable via votre bundle
        $delay = new \DateTime();
        $delay->setTimestamp(strtotime('5 minutes ago'));
    
        $qb = $this->getDoctrine()->getRepository('AppBundle:User')->createQueryBuilder('u')
        ->where('u.lastActivity > :delay')
        ->setParameter('delay', $delay);
    
        return $qb->getQuery()->getResult();
    }
}