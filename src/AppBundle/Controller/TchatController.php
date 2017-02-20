<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\LiveTchat;
use Symfony\Component\HttpFoundation\JsonResponse;

class TchatController extends Controller
{
    
    /**
     * @Route("/post_tchat_msg", name="post_tchat_msg")
     * @Method("POST")
     */
    public function post_tchat_msg(Request $request)
    {
        $to = $this->get('request')->get('to');
        $from = $this->get('request')->get('from');
        $value = $this->get('request')->get('value');
        
        $liveTchat = new LiveTchat();
        
        $liveTchat->setTo($to);
        $liveTchat->setFrom($from);
        $liveTchat->setValue($value);
        $liveTchat->setViewed(false);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($liveTchat);
        $em->flush();
        
        return new JsonResponse(array(
            'value' => 'ok'
        ));
    }

    /**
     * @Route("/get_tchat_msg", name="get_tchat_msg")
     * @Method("GET")
     */
    public function get_tchat_msg(Request $request)
    {
        $to = $this->get('request')->get('to');
        
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQueryBuilder()
		->select('live_tchat.id, live_tchat.from, live_tchat.value')
		->from('\AppBundle\Entity\LiveTchat', 'live_tchat')
		->where("live_tchat.to LIKE :to")->setParameter('to', $to)
        ->andWhere('live_tchat.viewed = 0')
        ->getQuery();
        $data = $query->getResult();
        
        return new JsonResponse(array(
            'value' => $data
        ));
    }
    
    /**
     * @Route("/set_viewed_tchat_msg", name="set_viewed_tchat_msg")
     * @Method("POST")
     */
    public function set_viewed_tchat_msg(Request $request)
    {
        $id = $this->get('request')->get('id');
    
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQueryBuilder()
        ->update('\AppBundle\Entity\LiveTchat', 'live_tchat')
        ->set('live_tchat.viewed', '1')
        ->where("live_tchat.id = :id")->setParameter('id', $id)
        ->getQuery();
        $data = $query->getResult();
        
        return new JsonResponse(array(
            'value' => $data
        ));
    }

}