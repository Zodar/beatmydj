<?php
namespace BmdUserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Form\UserType;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\ClassLoader;
use Doctrine\ORM\Query\Expr\Select;
use Doctrine\ORM\Query\Expr\From;
use AppBundle\Entity\Style;
use AppBundle\Form\StyleType;

class SearchController extends Controller
{

    /**
     *
     * @Route("/search", name="search_POST")
     * @Method("POST")
     * 
     * @param Request $request            
     */
    public function SearchAction(Request $request)
    {
        $name = $this->get('request')->get('name');
        
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        
        $qb->add('select', 'u.username')->add('from', 'AppBundle:User u');
        $qb->where('u.username LIKE :username')->setParameter('username', "%".$name."%");
        $q = $qb->getQuery();
        $results = $q->getResult();
        
        return new JsonResponse(array(
            'value' => $results
        ));
    }
    
    
    /**
     *
     * @Route("/search", name="search_advanced")
     * @Method("GET")
     *
     * @param Request $request
     */
    public function SearchAdvancedAction(Request $request)
    {
        $find = $this->getDoctrine()->getRepository('AppBundle:User');
        $finduser = $this->getDoctrine()->getRepository('AppBundle:User');
        $findDjRole = $this->getDoctrine()->getRepository('AppBundle:RoleAssociative');
        //$users = $find->findAll(Query::HYDRATE_ARRAY);
        $djs =  $findDjRole->findBy(array(
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
         
        $style = new Style();
        $form = $this->get('form.factory')->create(new StyleType, $style);
        $form = $form->createView();

        return $this->render('home/liste_dj.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            'users' => $datas,
             "form" => $form
        ));
    }
    
    /**
     *
     * @Route("/search_advanced", name="search_advancedPost")
     * @Method("POST")
     *
     * @param Request $request
     */
    public function SearchAdvancedPostAction(Request $request)
    {
        $find = $this->getDoctrine()->getRepository('AppBundle:User');
        
        $style = $this->get('request')->get('value');
        $params = array();
        parse_str($style, $params);
        unset($params["style"]["_token"]);
        $params = $params["style"];
        
        
        /* */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Style')->createQueryBuilder('s');
        $orX = $qb->expr()->orX();
        $value = false;
        foreach($params as $key => $value ){
             $orX->add("s.".$key ." = ". $value);
             $value = true;
        }
        if ($value == true)
        $qb->select('s.idUser')->where($orX);
        else 
            $qb->select('s.idUser');
        $matches_reply = $qb->getQuery()->getResult();
        
        
        /* */
        $id = array();
        foreach ($matches_reply as $dj) {
            $id[] = $dj["idUser"];
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
        
        return new JsonResponse(array(
            'success' => "true",
            'data' => $datas,
            "base" => $request->getSchemeAndHttpHost(),
            "match" => $matches_reply
        ));
    }
    
 
}