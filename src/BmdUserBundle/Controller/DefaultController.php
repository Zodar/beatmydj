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
use AppBundle\Entity\Style;
use AppBundle\Form\StyleType;

class DefaultController extends Controller
{
	 /**
     * Page ddes mentions légales
     * @Route("/mentions", name="mentions")
     * @Method("GET")
     *
     * @param Request $request
     */
	function mentionLegal()
	{
		return $this->render('home/mention_legal.html.twig');
	}
	/**
     * Page ddes mentions légales
     * @Route("/contact", name="contact")
     * @Method("GET")
     *
     * @param Request $request
     */
	function contact()
	{
		return $this->render('home/contact.html.twig');
	}
}
