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
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\UserBundle\Model\User as BaseUser;
/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User extends Controller implements UserInterface, ParticipantInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=4096, nullable=true)
     */
    private $presentation;

    /**
     * @ORM\ManyToOne(targetEntity="Style",cascade={"persist", "remove" })
     * @ORM\JoinColumn(nullable=true)
     */
    private $style;

    /**
     * @ORM\Column(type="string", length=4096, nullable=true)
     */
    private $dispo;
    
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $lastActivity;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;

    /**
     * @Assert\File(
     * maxSize="60000",
     * )
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $password;

    /**
     * @ORM\ManyToOne(targetEntity="RoleAssociative")
     * @ORM\JoinColumn(nullable=true)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $soundCloodLink;
    
    public function getLastActivity(){
        return $this->lastActivity;
    }
    public function setLastActivity($la){
        return $this->lastActivity = $la;
    }
    public function isActiveNow(){
        $this->setLastActivity(new \DateTime());
    }
    public function getSoundCloodLink() {
        return $this->soundCloodLink;
    }
    
    public function setSoundCloodLink($soundcloodLink) {
        $this->soundCloodLink = $soundcloodLink;
    }

    public function  getRole(){
        return ($this->role);
    }
    
    public function  setRole(RoleAssociative $role){
       $this->role = $role;
    }
    private $temp;
    // other properties and methods
    public function verif(Request $req)
    {
        if (! empty(trim($req->get('mail'))))
            $this->email = $req->get('mail');
        else
            return false;
        if (! empty(trim($req->get('firstname'))))
            $this->firstname = $req->get('firstname');
        else
            return false;
        
        if (! empty(trim($req->get('lastname'))))
            $this->lastname = $req->get('lastname');
        else
            return false;
        
        if (! empty(trim($req->get('pseudo'))))
            $this->username = $req->get('pseudo');
        else
            return false;
        
        if (! empty(trim($req->get('password'))))
            $this->plainPassword = $req->get('password');
        else
            return false;
        
        return true;
    }

    public function testUser()
    {
        $user = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneByEmail($this->email);
        
        return $user;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getId()
    {
        return ($this->id);
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getfirstname()
    {
        return $this->firstname;
    }

    public function getlastname()
    {
        return $this->lastname;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setfirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function setlastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return ($this->password);
    }

    public function setDispo($dispo)
    {
        $this->dispo = $dispo;
    }

    public function setStyle($style)
    {
        $params = array();
        parse_str($style, $params);
        unset($params["style"]["_token"]);
        
        if ($this->style == null){
            $this->style = new Style();
            $this->style->setIdUser($this->id);   
        }
        $this->style->init();
        foreach ($params["style"] as $key => $s ) {
            $test = "set".$key;
           $this->style->{$test}(true);
        }       
    }
    
    public function setStyleBase($style)
    {
        if ($this->style == null) {
            $this->style = new Style();
            $this->style->setIdUser($this->id);
        } else {
            $this->style->init();
            foreach ($params["style"] as $key => $s ) {
                $test = "set".$key;
                $this->style->{$test}(true);
            }    
        }
    }

    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;
    }

    public function getPresentation()
    {
        return ($this->presentation);
    }

    public function getStyle()
    {
        return ($this->style);
    }
    public $translator;
    public function getStyleText()
    {
        if($this->style == null) return(""); 
        $array = array("Dance","deep","disco","electro","funk","hiphop","house",
            "latino","reggae","rnb","rock","years80","years90"
        );
        $text = array();
        foreach ($array as $value){
            $mth = "get".$value;
            $stl = $this->style->{$mth}();
            if ($stl == true){
               $text[] = $value;
            }
        }
//         $text = substr($text, 0, -1);
        return ($text);
    }
    

//     public function getRole()
//     {
//         $find = $em->getDoctrine()->getRepository('AppBundle:RoleAssociative');
//         $find->findBy(array(
//             "idUser" => $this->id
//         ));
//         return ($find);
//     }

    public function getDispo()
    {
        return ($this->dispo);
    }

    public function getComment()
    {
        $find = $this->getDoctrine()->getRepository('AppBundle:Comment');
        $find->findBy(array(
            "userpage" => 21
        ));
        return ($find);
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            // $this->path = 'initial';
        }
    }

    public function getFile()
    {
        return $this->file;
    }

    public function eraseCredentials()
    {}

    public function getRoles()
    {
        return array(
            'ROLE_USER'
        );
    }

    public function getSalt()
    {
        // The bcrypt algorithm doesn't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    /* */
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDirPath() . '/' . $this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDirPath() . '/' . $this->path;
    }

    protected function getUploadRootDirPath()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../web/' . $this->getUploadDirPath();
    }

    protected function getUploadDirPath()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/dj_photos';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = basename($this->getFile()->getClientOriginalName(), '.' . $this->getFile()->getClientOriginalExtension());
            $this->path = $filename . '.' . $this->getFile()->getClientOriginalExtension();
            if (file_exists($this->getUploadRootDirPath() . '/' . $this->path) == 1) {
                $this->path = $this->id . '.' . $this->getFile()->getClientOriginalExtension();
            }
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        
        $this->path = $this->id . '.' . $this->getFile()->getClientOriginalExtension();
        $this->getFile()->move($this->getUploadRootDirPath(), $this->path);
        
        if (isset($this->temp)) {
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }

    public function __toString()
    {
        return "";
    }
    // other methods, including security methods like getRoles()
}

/**
 * @ORM\Entity
 */
class RoleAssociative extends Controller
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

//     /**
//      * @ORM\ManyToOne(targetEntity="User", inversedBy="role")
//      * @ORM\JoinColumn(name="idUser", referencedColumnName="id")
//      */
//     private $user;

    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    private $idUser;
    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    private $idRole;
    


    public function getidUser()
    {
        return $this->idUser;
    }

    public function getidRole()
    {
        return $this->idRole;
    }

    public function setidUser($idUser)
    {
        $this->idUser = $idUser;
    }

    public function setidRole($idRole)
    {
        $this->idRole = $idRole;
    }

    // other methods, including security methods like getRoles()
}