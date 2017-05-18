<?php
namespace AppBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener {

  /**
   *
   * @param AuthenticationSuccessEvent $event
   */
  public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event) {
    $data = $event->getData ();
    $user = $event->getUser ();
    if (! $user instanceof UserInterface) {
      return;
    }

    $userinfo = [];
    $userinfo["id"] = $user->getId();
    $userinfo["email"] = $user->getEmail();
    $userinfo["firstName"] = $user->getFirstName();
    $userinfo["lastName"] = $user->getLastName();
    $userinfo["userName"] = $user->getUserName();
    $userinfo["presentation"] = $user->getPresentation();
    $userinfo["style"] = $user->getStyle();
    $userinfo["dispo"] = $user->getDispo();
    $userinfo["path"] = $user->path;
    $data ['user'] = $userinfo;
    $event->setData ( $data );
  }
}