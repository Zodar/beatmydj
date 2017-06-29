<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Style;
use AppBundle\Form\StyleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use BmdUserBundle\Controller\ListeController;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Entity\Comment;
use Doctrine\ORM\Query;
use \DateTime;
use \DateInterval;
use BmdUserBundle\Entity\ClientView;

class DefaultController extends Controller
{

    /**
     * Point d'entrée de l'index
     * Récupère  certains users selon plusieurs critères puis les renvoient à la vu afin d'y être affiché
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
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
        
        $lastUser = array_pop($datas);
        $firstUser = array_shift($datas);
        $randomUser = null;
        if (! empty($datas)) {
            $randomUser = $datas[array_rand($datas)];
        }
        
        return $this->render('home/home.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            'firstUser' => $firstUser,
            'randomUser' => $randomUser,
            'lastUser' => $lastUser
        ));
    }

    /* Méthode trie */
    function sortFunction($a, $b)
    {
        return strtotime($a->getAllMetadata()[0]->getLastParticipantMessageDate()) - strtotime($b->getAllMetadata()[0]->getLastParticipantMessageDate());
    }

    

    /**
     *
     * @Route("/avis",options={"expose"=true}, name="post_avis")
     * @Method("POST")
     *
     * @param Request $request
     */
    public function sendReview(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){
            $usr = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        }

        $note = $this->get('request')->get('note');
        $text = $this->get('request')->get('text');
        $page = $this->get('request')->get('page');
        $message = \Swift_Message::newInstance()
        ->setSubject('Un utilisateur a laissé un avis')
        ->setFrom('website@beatmydj.com')
        ->setTo('beat.my.dj@gmail.com')
        ->setBody("Un utilisateur a laissé un avis! <br/>Page: $page <br/> note: $note <br/> avis: $text",'text/html'
        ) ;
        
        
        return new JsonResponse(array(
            'success' => "success",
            'mail' => $this->get('mailer')->send($message)
        ));
    }
    /**
     * @Route("/messages", name="messages")
     * @Method("GET")
     *
     * @param Request $request            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function messagesActionGet(Request $request)
    {
        $provider = $this->get('fos_message.provider');
        
        $threads = $provider->getInboxThreads();
        $threads_sent = $provider->getSentThreads();
        
        $thread = [];
        $inbox_ids = [];
        
        foreach ($threads as $t) {
            $t2 = $provider->getThread($t->getid());
            $inbox_ids[] = $t->getid();
            $thread[] = $t2;
        }
        
        foreach ($threads_sent as $t) {
            $add = true;
            $t2 = $provider->getThread($t->getid());
            foreach ($inbox_ids as $inbox_id) {
                if ($inbox_id == $t->getid()) {
                    $add = false;
                }
            }
            if ($add) {
                $thread[] = $t2;
            }
        }
        
        return $this->render('messages/general.html.twig', array(
            "thread" => $thread
        ));
    }

    /**
     * @Route("/messages", name="messages_post")
     * @Method("POST")
     *
     * @param Request $request            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function messagesActionPost(Request $request)
    {
        $composer = $this->get('fos_message.composer');
        $provider = $this->get('fos_message.provider');
        $thread = $provider->getThread($this->get('request')
            ->get('id'));
        
        $message = $composer->reply($thread)
            ->setSender($this->get('security.token_storage')
            ->getToken()
            ->getUser())
            ->setBody($this->get('request')
            ->get('body'))
            ->getMessage();
        
        $sender = $this->get('fos_message.sender');
        
        $sender->send($message);
        
        return new JsonResponse(array(
            'success' => "success"
        ));
    }

    /**
     * @Route("/messages_new", name="messages_new")
     * @Method("POST")
     *
     * @param Request $request            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function messagesActionPostNew(Request $request)
    {
        $find = $this->getDoctrine()->getRepository('AppBundle:User');
        $usr = $find->find($this->get('request')
            ->get('userId'));
        $currentUsr = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        
        $composer = $this->get('fos_message.composer');
        $provider = $this->get('fos_message.provider');
        $sender = $this->get('fos_message.sender');
        
        $alreadyHave = DefaultController::alreadyHaveDiscuss($usr, $currentUsr, $composer, $provider);
        
        if (! $alreadyHave) {
            $message = $composer->newThread()
                ->setSender($currentUsr)
                ->addRecipient($usr)
                ->setSubject('Messages')
                ->setBody($this->get('request')
                ->get('body'))
                ->getMessage();
        } else {
            $message = $composer->reply($alreadyHave)
                ->setSender($currentUsr)
                ->setBody($this->get('request')
                ->get('body'))
                ->getMessage();
        }
        
        $sender->send($message);
        
        return new JsonResponse(array(
            'success' => "success"
        ));
    }

    public static function alreadyHaveDiscuss($usr, $currentUsr, $composer, $provider)
    {
        $threads = $provider->getSentThreads();
        
        if (empty($threads)) {
            return false;
        }
        
        foreach ($threads as $thread) {
            $participants = $thread->getParticipants();
            foreach ($participants as $p) {
                if ($p->getId() == $usr->getId()) {
                    return $thread;
                }
            }
        }
    }

    /* Vérifie si l'existence de steam en cours */
    public function check_stream($uid)
    {
        $date = new DateTime();
        ;
        $Events = $this->getDoctrine()
            ->getManager()
            ->getRepository('BmdUserBundle:UserAvailability')
            ->createQueryBuilder('e')
            ->where('e.dateStart <= :date AND e.dateEnd >= :date AND e.userid = :userId')
            ->setParameter('date', $date->format('Y-m-d H:i:s'))
            ->setParameter('userId', $uid)
            ->getQuery()
            ->getResult();
        if (empty($Events))
            return null;
        
        return $Events[0];
    }

    /**
     * @Route("/profil",options={"expose"=true}, name="profil")
     * @Route("/profil/{user}", name="all_profil")
     */
    public function profil(Request $request, $user = null)
    {
        if (! $this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('homepage');
        }
        $form = "rien";
        if ($user != null) {
            $find = $this->getDoctrine()->getRepository('AppBundle:User');
            $pseudo = $find->findBy(array(
                "username" => $user
            ));
            if (! isset($pseudo[0]))
                return $this->redirect($this->generateUrl('homepage'));
            $usr = $pseudo[0];
        } else {
            $usr = $this->get('security.token_storage')
                ->getToken()
                ->getUser();
            $usrUserName = $this->get('security.token_storage')
                ->getToken()
                ->getUser()
                ->getUsername();
            $style = $usr->getStyle();
            $form = $this->get('form.factory')->create(new StyleType(), $style);
            $form = $form->createView();
        }
        
        if (isset($usrUserName) && $user == $usrUserName) {
            $user = null;
        } else {
            $this->generateClientView($usr->getId());
        }
        
        $find = $this->getDoctrine()->getRepository('AppBundle:Comment');
        $comment = $find->findBy(array(
            "userpage" => $usr->getId()
        ));
        
        return $this->render('home/profil.html.twig', array(
            "user" => $usr,
            "own" => $user,
            "Allcomment" => $comment,
            "form" => $form,
            "live" => $this->check_stream($usr->getId())
        ));
    }

    private function generateClientView($username)
    {
        $usr = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        if ($usr->getRole()->getidRole() == 4) {
            $clientView = new ClientView();
            
            $clientView->setClient($usr->getUsername());
            $clientView->setVisited($username);
            $clientView->setDate();
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($clientView);
            $em->flush();
        }
    }
}
