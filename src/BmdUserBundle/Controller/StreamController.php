<?php
namespace BmdUserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StreamController extends Controller
{

    /**
     *
     * @Route("/streamHome", name="streamHome")
     * @Method("GET")
     *
     * @param Request $request
     */
    public function streamHome(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('home/streamRoom.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            'currentUserRole' => $user->getRole()->getidRole()
        ));
    }
    
    /**
     * @Route("/stream", name="streamDJ")
     * @Route("/stream/{user}", name="streamClient")
     */
    public function profil(Request $request, $user = null) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('homepage');
        }
        
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        
        return $this->render('home/streamRoom.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            'currentUserRole' => $currentUser->getRole()->getidRole(),
            'currentUserId' => $currentUser->getId(),
            'DJID' => $user
        ));
    }

}
?>