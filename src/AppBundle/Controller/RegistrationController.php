<?php
// src/AppBundle/Controller/RegistrationController.php
namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\RoleAssociative;
use AppBundle\Entity\AppBundle\Entity;
use AppBundle\Entity\Style;

class RegistrationController extends Controller
{

    /**
     * @Route("/register", name="user_registration")
     * @Method("POST")
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
		/* Si toutes les infos sont bien rempli */
        if ($user->verif($this->get('request')) == false) {
            return new JsonResponse(array(
                'name' => "Veuillez remplir toutes les infos",
                'value' => "false"
            ));
        }

		/* Regarde si le mail ou pseudo existe déja */
        $find = $this->getDoctrine()->getRepository('AppBundle:User');
        $email = $find->findOneByEmail($user->getEmail());
        $pseudo = $find->findBy(array(
            "username" => $user->getUsername()
        ));

        if (! empty($email))
            return new JsonResponse(array(
                'name' => "L'email est déja utilisé",
                'value' => "false"
            ));
        if (! empty($pseudo)) {
            $lsPseudo = $this->addPseudoRandom();
            return new JsonResponse(array(
                'name' => "Le pseudo est déja utilisé Suggestion de pseudo ".$lsPseudo,
                'value' => "false"
            ));
        }

        $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        
        /**
         * VALEURS PAR DEFAUT
         */
        $user->setPresentation("Hello, I'm a new user of BEAT MY DJ ! :)");
        $user->path = "default.png";
        $user->setSoundCloodLink("https://soundcloud.com/beat-my-dj-beat-my-dj/sets/beatmydj");
        
        $role = $this->get('request')->get('role');
        
        if ($role == null)
            return new JsonResponse(array(
                'name' => "Veuillez remplir toutes les infos",
                'value' => "false"
            ));
            
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $id = $user->getId();
        
        $style = new Style();
        $style->setIdUser($id);
        $user->setStyleBase($style);
        
        $userRole = new RoleAssociative();

        $userRole->setidRole($role);
        $userRole->setidUser($id);
        $em->persist($userRole);
        $em->flush();
        $user->setRole($userRole);
       
        // 4) save the User!
        $em->persist($user);
        $em->flush();
        return new JsonResponse(array(
            'name' => "Utilisateur enregistré",
            'value' => "true"
        ));
    }

    /**
	 * @TODO a supprimer a mon avis 
     * @Route("/register", name="user_get_registration")
     * @Method("GET")
     */
    public function getRegisterPage(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $user->setEmail("aaa@aaa.fr");

        $form->handleRequest($request);
        return $this->render('registration/register.html.twig', array(
            'form' => $form->createView()
        ));
    }

	/**
	* Action de login
	*/
    public function loginAction(Request $request)
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('homepage');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }
    /**
     * Function get random pseudo with randomuser api
     *
     * @var string
     *
     */
    protected function addPseudoRandom(){
        $lsUrl = 'https://randomuser.me/api/?key=42PY-2LAL-HFCP-27HC&ref=onws1zax';
        $loCurl = curl_init();
        curl_setopt($loCurl, CURLOPT_URL, $lsUrl);
        curl_setopt($loCurl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($loCurl, CURLOPT_HTTPGET, 1);
        curl_setopt($loCurl, CURLOPT_RETURNTRANSFER, true);
        $lsResponse = curl_exec($loCurl);
        curl_close($loCurl);
        $lsResponse = json_decode($lsResponse);
        return ($lsResponse->results[0]->login->username);
    }
}