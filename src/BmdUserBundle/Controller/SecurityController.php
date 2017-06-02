<?php

namespace BmdUserBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
class SecurityController extends Controller
{
    
    
    /**
     *
     *@Route("/login", name="login")
     * @param Request $request
     */
  public function loginAction(Request $request)
  {
    // Si le visiteur est déjà identifié, on le redirige vers l'accueil
    if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
      return $this->redirect($this->generateUrl('profil'));
    }

    // Le service authentication_utils permet de récupérer le nom d'utilisateur
    // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
    // (mauvais mot de passe par exemple)
    $authenticationUtils = $this->get('security.authentication_utils');

    return $this->render('BmdUserBundle:Security:login.html.twig', array(
        'last_username' => $authenticationUtils->getLastUsername(),
        'error'         => $authenticationUtils->getLastAuthenticationError(),
    ));
  }


   /**
     *@Route("/loginMobile", name="loginmobile")
     * @param Request $request
     */
  public function loginActionMobileOualid(Request $request)
  {
    header('Access-Control-Allow-Origin: *');
    $find = $this->getDoctrine()->getRepository('AppBundle:User');
    $user = $find->findOneByEmail($this->get('request')->query->get('_username'));
    $pseudo = $find->findBy(array(
      "username" => $this->get('request')->query->get('_username')
    ));
  // if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
  //       return new JsonResponse(array("user" => "deja connecte"));
  // }
    if (count($pseudo) == 1) {

    $user = $pseudo[0];
    $token = new UsernamePasswordToken($user,$this->get('request')->query->get('_password'), "main", $user->getRoles());
    $this->get("security.context")->setToken($token);

$this->get("security.context")->setToken($token);

    $event = new InteractiveLoginEvent($request, $token);
    $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
    return new JsonResponse(array("user" => $pseudo[0]->getEmail(),"token" => $token->serialize()));
  }

    return new JsonResponse(array("user" => "null"));


    /*

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


$em = $this->getDoctrine();
$repo  = $em->getRepository("UserBundle:User"); //Entity Repository
$user = $repo->loadUserByUsername($username);
if (!$user) {
    throw new UsernameNotFoundException("User not found");
} else {
    $token = new UsernamePasswordToken($user, null, "your_firewall_name", $user->getRoles());
    $this->get("security.context")->setToken($token); //now the user is logged in
     
    //now dispatch the login event
    $request = $this->get("request");
    $event = new InteractiveLoginEvent($request, $token);
    $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
}
    */
  }
}