<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
Class qui contiendra les urls propres a l'API 
**/
class DefaultController extends Controller
{
 
 
    /**
     * Url de test de l'api
     * @Route("/api/testmobile", name="testmobile")
     * @Method("POST")
     *
     * @param Request $request
     */
    // public function testMobile(Request $request)
    // {
    //   if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
    //     $usr = $this->get('security.token_storage')
    //     ->getToken()
    //     ->getUser();

    //     return new JsonResponse(array(
    //         'success' => "true"
    //     ));
    //   }
    //   return new JsonResponse(array(
    //       'success' => "false"
    //   ));
    // }
}
