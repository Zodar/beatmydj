<?php
namespace BmdUserBundle\Twig;


use Symfony\Bridge\Doctrine\RegistryInterface;
class TwigExtensions extends \Twig_Extension
{
    public function getFunctions()
    {
        // Register the function in twig :
        // In your template you can use it as : {{find(123)}}
        return array(
            new \Twig_SimpleFunction('findUser', array($this, 'findUser')),
        );
    }
    
    protected $doctrine;
    // Retrieve doctrine from the constructor
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    public function findUser($id){
        $em = $this->doctrine->getManager();
        $myRepo = $em->getRepository('AppBundle:User');
        ///
        
        return $myRepo->find($id);
    }
    
    public function getName()
    {
        return 'Twig myCustomName Extensions';
    }
}

