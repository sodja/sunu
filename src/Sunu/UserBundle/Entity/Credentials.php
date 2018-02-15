<?php

namespace Sunu\UserBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Credentials
{
  /**
     * @var string
     *
     * 
	 * @Assert\NotBlank()
     *      
     *        
     */
    protected $login;
	
	/**
     * @var string
     *
     * 
	 * @Assert\NotBlank()
     *      
     *        
     */

    protected $password;

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}

