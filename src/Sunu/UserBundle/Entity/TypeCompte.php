<?php

namespace Sunu\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeCompte
 *
 * @ORM\Table(name="type_compte")
 * @ORM\Entity(repositoryClass="Sunu\UserBundle\Repository\TypeCompteRepository")
 */
class TypeCompte
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleTypeCompte", type="string", length=255)
     */
    private $libelleTypeCompte;

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
     * Set libelleTypeCompte
     *
     * @param string $libelleTypeCompte
     *
     * @return typeCompte
     */
    public function setLibelleTypeCompte($libelleTypeCompte)
    {
        $this->libelleTypeCompte = $libelleTypeCompte;

        return $this;
    }

    /**
     * Get libelleTypeCompte
     *
     * @return string
     */
    public function getLibelleTypeCompte()
    {
        return $this->libelleTypeCompte;
    }
}

