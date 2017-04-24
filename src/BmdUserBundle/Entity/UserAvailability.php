<?php
namespace BmdUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class UserAvailability
{

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
     * @ORM\Column(type="boolean",nullable=true, options={"default":false})
     * @Assert\NotBlank()
     */
    private $accept;

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

    public function getaccept()
    {
        return $this->userid;
    }

    public function setaccept($accept)
    {
        $this->accept = $accept;
    }

    public function getuserid()
    {
        return $this->userid;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setuserid($userid)
    {
        $this->userid = $userid;
    }

    public function setauteur($userid)
    {
        $this->auteur = $userid;
    }

    public function setdatestart($date)
    {
        $this->dateStart = $date;
    }

    public function setdateend($date)
    {
        $this->dateEnd = $date;
    }

    public function getdateStart()
    {
        return ($this->dateStart);
    }

    public function getdateEnd()
    {
        return ($this->dateEnd);
    }

    public function getAuteur()
    {
        return ($this->auteur);
    }

    public function toArray()
    {
        $event = array();
        
        $event['id'] = $this->id;
        
        $event['title'] = "Live pour " . $this->auteur;
        $event['start'] = $this->dateStart->format("Y-m-d\TH:i:sP");
        
        $event['url'] = "#";
        
        $event['backgroundColor'] = "#FF0000";
        $event['borderColor'] = "#FF0000";

        $event['className'] = "my-custom-class";
        
        $event['end'] = $this->dateEnd->format("Y-m-d\TH:i:sP");
        
        $event['allDay'] = false;
        
        return $event;
    }
}

?>