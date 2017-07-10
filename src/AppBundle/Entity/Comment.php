<?php 

// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Cunningsoft\ChatBundle\Entity\AuthorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
 * Clas qui definit l'entité Comment contiens les commentaires sur les pages profils
 * @ORM\Entity
 */
class Comment extends Controller
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1024, unique=false)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $content;

    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    public $userid;

    /**
     * @ORM\Column(type="string", length=255, unique=false))
     */
    public $pseudo;
    
    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    public $userpage;
    
    /**
     * @ORM\Column(type="string", length=255, unique=false))
     */
    public $response;

    
    /**
     * @ORM\Column(type="datetime", length=255, unique=false))
     * @var \DateTime
     */
    private $date;
    
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getDate(){
        return ($this->date);
    }
}

