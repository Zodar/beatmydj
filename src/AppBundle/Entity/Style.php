<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class Style
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    private $idUser;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $deep;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $electro;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $house;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $years80;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $years90;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $disco;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $rock;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $dance;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $hiphop;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $reggae;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $rnb;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $latino;
    
    /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    private $funk;

    
    public function init(){
        $this->setDance(false);
        $this->deep = false;
        $this->disco = false;
        $this->electro = false;
        $this->funk = false;
        $this->hiphop = false;
        $this->house = false;
        $this->latino = false;
        $this->reggae = false;
        $this->rnb = false;
        $this->rock = false;
        $this->years80 = false;
        $this->years90 = false;
        
        return ($this);
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idUser
     *
     * @param string $idUser
     *
     * @return Style
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return string
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set deep
     *
     * @param boolean $deep
     *
     * @return Style
     */
    public function setDeep($deep)
    {
        $this->deep = $deep;

        return $this;
    }

    /**
     * Get deep
     *
     * @return boolean
     */
    public function getDeep()
    {
        return $this->deep;
    }

    /**
     * Set electro
     *
     * @param boolean $electro
     *
     * @return Style
     */
    public function setElectro($electro)
    {
        $this->electro = $electro;

        return $this;
    }

    /**
     * Get electro
     *
     * @return boolean
     */
    public function getElectro()
    {
        return $this->electro;
    }

    /**
     * Set house
     *
     * @param boolean $house
     *
     * @return Style
     */
    public function setHouse($house)
    {
        $this->house = $house;

        return $this;
    }

    /**
     * Get house
     *
     * @return boolean
     */
    public function getHouse()
    {
        return $this->house;
    }

    /**
     * Set years80
     *
     * @param boolean $years80
     *
     * @return Style
     */
    public function setYears80($years80)
    {
        $this->years80 = $years80;

        return $this;
    }

    /**
     * Get years80
     *
     * @return boolean
     */
    public function getYears80()
    {
        return $this->years80;
    }

    /**
     * Set years90
     *
     * @param boolean $years90
     *
     * @return Style
     */
    public function setYears90($years90)
    {
        $this->years90 = $years90;

        return $this;
    }

    /**
     * Get years90
     *
     * @return boolean
     */
    public function getYears90()
    {
        return $this->years90;
    }

    /**
     * Set disco
     *
     * @param boolean $disco
     *
     * @return Style
     */
    public function setDisco($disco)
    {
        $this->disco = $disco;

        return $this;
    }

    /**
     * Get disco
     *
     * @return boolean
     */
    public function getDisco()
    {
        return $this->disco;
    }

    /**
     * Set rock
     *
     * @param boolean $rock
     *
     * @return Style
     */
    public function setRock($rock)
    {
        $this->rock = $rock;

        return $this;
    }

    /**
     * Get rock
     *
     * @return boolean
     */
    public function getRock()
    {
        return $this->rock;
    }

    /**
     * Set dance
     *
     * @param boolean $dance
     *
     * @return Style
     */
    public function setDance($dance)
    {
        $this->dance = $dance;

        return $this;
    }

    /**
     * Get dance
     *
     * @return boolean
     */
    public function getDance()
    {
        return $this->dance;
    }

    /**
     * Set hiphop
     *
     * @param boolean $hiphop
     *
     * @return Style
     */
    public function setHiphop($hiphop)
    {
        $this->hiphop = $hiphop;

        return $this;
    }

    /**
     * Get hiphop
     *
     * @return boolean
     */
    public function getHiphop()
    {
        return $this->hiphop;
    }

    /**
     * Set reggae
     *
     * @param boolean $reggae
     *
     * @return Style
     */
    public function setReggae($reggae)
    {
        $this->reggae = $reggae;

        return $this;
    }

    /**
     * Get reggae
     *
     * @return boolean
     */
    public function getReggae()
    {
        return $this->reggae;
    }

    /**
     * Set rnb
     *
     * @param boolean $rnb
     *
     * @return Style
     */
    public function setRnb($rnb)
    {
        $this->rnb = $rnb;

        return $this;
    }

    /**
     * Get rnb
     *
     * @return boolean
     */
    public function getRnb()
    {
        return $this->rnb;
    }

    /**
     * Set latino
     *
     * @param boolean $latino
     *
     * @return Style
     */
    public function setLatino($latino)
    {
        $this->latino = $latino;

        return $this;
    }

    /**
     * Get latino
     *
     * @return boolean
     */
    public function getLatino()
    {
        return $this->latino;
    }

    /**
     * Set funk
     *
     * @param boolean $funk
     *
     * @return Style
     */
    public function setFunk($funk)
    {
        $this->funk = $funk;

        return $this;
    }

    /**
     * Get funk
     *
     * @return boolean
     */
    public function getFunk()
    {
        return $this->funk;
    }
}
