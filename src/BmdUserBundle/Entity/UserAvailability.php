<?php 
namespace BmdUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 */
Class UserAvailability {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    
    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    private $userid;
    
    
    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    private $auteur;
    
    
    /**
     * @Assert\Date()
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $dateStart;
    
    /**
     * @Assert\Date()
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $dateEnd;
    
    public function setuserid($userid){
        $this->userid = $userid;
    }
    public function setauteur($userid){
        $this->auteur = $userid;
    }
    
    
    public function setdatestart($date){
        $this->dateStart = $date;
    }
    
    public function setdateend($date){
        $this->dateEnd = $date;
    }
    
    public function getdateStart(){
        return ($this->dateStart);
    }
    
    public function getdateEnd(){
        return ($this->dateEnd);
    }
    
    public function getAuteur(){
        return ($this->auteur);
    }
    
}




?>