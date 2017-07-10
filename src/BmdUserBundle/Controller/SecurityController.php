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
	 * @TODO a supprimer mon avis 
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
    if (count($pseudo) == 1) {

    $user = $pseudo[0];
    $token = new UsernamePasswordToken($user,$this->get('request')->query->get('_password'), "main", $user->getRoles());
    $this->get("security.context")->setToken($token);
    $event = new InteractiveLoginEvent($request, $token);
    $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
    return new JsonResponse(array("user" => $pseudo[0]->getEmail(),"token" => $token->serialize()));
  }

    return new JsonResponse(array("user" => "null"));
  }
}