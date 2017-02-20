<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="live_tchat")
 */
class LiveTchat
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="`from`", type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    protected $from;
    
    /**
     * @ORM\Column(name="`to`", type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    protected $to;
    
    /**
     * @ORM\Column(name="`value`", type="string", length=255, unique=false)
     */
    protected $value;
    
    /**
     * @ORM\Column(name="`viewed`", type="boolean", unique=false)
     */
    protected $viewed;

    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getFrom() {
        return $this->from;
    }
    
    public function setFrom($from) {
        $this->from = $from;
    }
    
    public function getTo() {
        return $this->to;
    }
    
    public function setTo($to) {
        $this->to = $to;
    }
    
    public function getValue() {
        return $this->value;
    }
    
    public function setValue($value) {
        $this->value = $value;
    }   
    
    public function getViewed() {
        return $this->viewed;
    }
    
    public function setViewed($viewed) {
        $this->viewed = $viewed;
    }
}