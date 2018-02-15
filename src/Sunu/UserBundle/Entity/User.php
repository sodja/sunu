<?php

namespace Sunu\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FosUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Sunu\UserBundle\Repository\UserRepository")
 */
class User extends FosUser
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

  /**
   * @ORM\OneToOne(targetEntity="Sunu\UserBundle\Entity\Compte",cascade={"persist"})
   * @ORM\JoinColumn(nullable=true)
   */
    private $compte;

    /**
     * @ORM\Column(name="profile", type="string", nullable=true)
     * 
     */
    private $profile;

    /**
     * @ORM\Column(name="nom", type="string", nullable=false)
     * 
     */
    private $nom;

    /**
     * @ORM\Column(name="prenom", type="string", nullable=true)
     * 
     */
    private $prenom;

    /**
     * @ORM\Column(name="libellesecret", type="string", nullable=false)
     * 
     */
    private $libellesecret;

     /**
     * @ORM\Column(name="secret", type="string", nullable=false)
     * 
     */
    private $secret;

    /**
     * @ORM\Column(name="lastname", type="string", nullable=true)
     * 
     */
    protected $lastname;


    /**
     * @ORM\Column(name="lastActivity", type="datetime", nullable=true)
     * 
     */
    private $lastActivity;


    public function __construct()
    {
        parent::__construct();	
        $this->lastname = "tailleur";	 
    }

    public function isActiveNow()
	{
        $this->setLastActivity(new \DateTime());
    }

    public function setUsername($username)
	{
        parent::setUsername($username);
        $this->setEmail($username.'@live.ne');
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function setProfile($profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set compte
     *
     * @param \Sunu\UserBundle\Entity\Compte $compte
     *
     * @return User
     */
    public function setCompte(\Sunu\UserBundle\Entity\Compte $compte)
    {
        $this->compte = $compte;
		 // A cause de cette ligne,dans le reste du code il faudra utiliser $user->setCompte() qui garde la coherence du code, mais jamais $compte->setUser
		
        return $this;
    }

    /**
     * Get compte
     *
     * @return \Sunu\UserBundle\Entity\Compte
     */
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * Set nom
     *
     * @param $nom
     *
     * @return nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Set prenom
     *
     * @param $prenom
     *
     * @return prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * Set libellesecret
     *
     * @param $libellesecret
     *
     * @return libellesecret
     */
    public function setLibellesecret($libellesecret)
    {
        $this->libellesecret = $libellesecret;
    }

    /**
     * Set secret
     *
     * @param $secret
     *
     * @return secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * Get libellesecret
     *
     * @return libellesecret
     */
    public function getLibellesecret()
    {
        return $this->libellesecret;
    }
    
    /**
     * Get secret
     *
     * @return secret
     */
    public function getsecret()
    {
        return $this->secret;
    }

    /**
     * Set lastActivity
     *
     * @param \DateTime $lastActivity
     * @return User
     */
    public function setLastActivity($lastActivity)
    {
        $this->lastActivity = $lastActivity;
    }

    /**
     * Get lastActivity
     *
     * @return \DateTime 
     */
    public function getLastActivity()
    {
        return $this->lastActivity;
    }

    /**
     * Get nom
     *
     * @return nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Get prenom
     *
     * @return prenom
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
}

