<?php

namespace Sunu\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compte
 *
 * @ORM\Table(name="compte")
 * @ORM\Entity(repositoryClass="Sunu\UserBundle\Repository\CompteRepository")
 */
class Compte
{

    public function __construct()

    {
      $this->statut = "inactif";	  
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

  /**
   * @ORM\ManyToOne(targetEntity="Sunu\UserBundle\Entity\TypeCompte", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
  
  private $typeCompte;

  	/**
     * @var string
     *
     * @ORM\Column(name="code_inscription", type="string", length=255,nullable=true)
     */
    private $codeinscription;
	
 /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expiration_code_inscription", type="datetime",nullable=true)
     */
    private $dateExpireCodeInscription;
	
	/**
     * @var string
     *
     * @ORM\Column(name="statut_expire_code_inscription", type="string", length=255,nullable=true)
     */
    private $statutExpireCodeInscription;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255)
     */
    private $statut;

    /**
     * Set typeCompte
     *
     * @param \Sunu\PortefeuilleBundle\Entity\typeCompte $typeCompte
     *
     * @return Compte
     */
    public function setTypeCompte(\Sunu\UserBundle\Entity\typeCompte $typeCompte)
    {
        $this->typeCompte = $typeCompte;

        return $this;
    }

    /**
     * Get typeCompte
     *
     * @return \Sunu\UserBundle\Entity\typeCompte
     */
    public function getTypeCompte()
    {
        return $this->typeCompte;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Compte
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
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
     * Set codeinscription
     *
     * @param string $codeinscription
     *
     * @return Compte
     */
    public function setCodeinscription($codeinscription)
    {
        $this->codeinscription = $codeinscription;

        return $this;
    }

    /**
     * Get codeinscription
     *
     * @return string
     */
    public function getCodeinscription()
    {
        return $this->codeinscription;
    }

    /**
     * Set dateExpireCodeInscription
     *
     * @param \DateTime $dateExpireCodeInscription
     *
     * @return Compte
     */
    public function setDateExpireCodeInscription($dateExpireCodeInscription)
    {
        $this->dateExpireCodeInscription = $dateExpireCodeInscription;

        return $this;
    }

    /**
     * Get dateExpireCodeInscription
     *
     * @return \DateTime
     */
    public function getDateExpireCodeInscription()
    {
        return $this->dateExpireCodeInscription;
    }

    /**
     * Set statutExpireCodeInscription
     *
     * @param string $statutExpireCodeInscription
     *
     * @return Compte
     */
    public function setStatutExpireCodeInscription($statutExpireCodeInscription)
    {
        $this->statutExpireCodeInscription = $statutExpireCodeInscription;

        return $this;
    }

    /**
     * Get statutExpireCodeInscription
     *
     * @return string
     */
    public function getStatutExpireCodeInscription()
    {
        return $this->statutExpireCodeInscription;
    }
}

