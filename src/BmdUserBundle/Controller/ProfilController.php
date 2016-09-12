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
class ProfilController extends Controller
{

    /**
     *
     * @Route("/profil/edit", name="edit_profil")
     * @Method("GET")
     *
     * @param Request $request            
     */
    public function EditProfilAction(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
            return $this->render('BmdUserBundle:Profil:edit.html.twig', array());
        else
            return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     *
     * @Route("/profil/edit", name="edit_profil_POST")
     * @Method("POST")
     *
     * @param Request $request            
     */
    public function EditProfilActionPOST(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            
            $usr = $this->get('security.token_storage')->getToken()->getUser();
            
            if ($this->get('request')->get('name') != null) {
                if ($this->get('request')->get('name') == "userFirstName") {
                    $usr->setfirstname($this->get('request')->get('value'));
                } else if ($this->get('request')->get('name') == "userLastName") {
                    $usr->setlastname($this->get('request')->get('value'));
                } else if ($this->get('request')->get('name') == "userLocation") {
                    $usr->setLocation($this->get('request')->get('value'));
                } else if ($this->get('request')->get('name') == "userEmail") {
                    $usr->setEmail($this->get('request')->get('value'));
                } else if ($this->get('request')->get('name') == "tarif") {
                    $usr->setTarif($this->get('request')->get('value'));
                } else if ($this->get('request')->get('name') == "style") {
                    $usr->setStyle($this->get('request')->get('value'));
                } else if ($this->get('request')->get('name') == "userPresentation") {
                    $usr->setPresentation($this->get('request')->get('value'));
                } else if ($this->get('request')->get('name') == "changePlaylist") {
                    $usr->setSoundCloodLink($this->get('request')->get('value'));                     
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
     *
     * @Route("/profil/remove", name="remove_POST")
     * @Method("POST")
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
            $this->get('request')->getSession()->invalidate();
            
            return new JsonResponse(array(
                'success' => "true"
            ));
        }
        return new JsonResponse(array(
            'success' => "false"
        ));
    }

    /**
     *
     * @Route("/profil/addcomment", name="comment_POST")
     * @Method("POST")
     *
     * @param Request $request            
     */
    public function AddCommentProfllActionPOST(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $usr = $this->get('security.token_storage')
                ->getToken()
                ->getUser();
            
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
     *
     * @Route("/profil/edit/picture", name="edit_profil_image_POST")
     * @Method("POST")
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