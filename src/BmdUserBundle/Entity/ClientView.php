<?php
namespace BmdUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class ClientView{
    
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
    private $visited;
    
    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    private $client;
    

    /**
     * @Assert\Date()
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $date;

    
    public function getId()
    {
        return $this->id;
    }
    
    public function setClient($client)
    {
        $this->client = $client;
    }
    
    public function setVisited($visited)
    {
        $this->visited = $visited;
    }
    
    public function setDate()
    {
        $this->date = new \DateTime();
    }
    
    
    public function getDate()
    {
        return ($this->date);
    }
    
    public function getVisited()
    {
        return ($this->visited);
    }
    
    public function getClient()
    {
        return ($this->client);
    }
    
}