<?php

namespace Sunu\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use Sunu\UserBundle\Form\UserRestType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

use Sunu\UserBundle\Entity\Credentials;
use Sunu\UserBundle\Entity\User;
use Sunu\ClientBundle\Entity\Client;
use Sunu\UserBundle\Entity\TypeCompte;
use Sunu\UserBundle\Entity\Compte;

class UserRestController extends Controller
{

    public function indexAction()
    {
        return $this->render('SunuUserBundle:Default:index.html.twig');
    }

    /**
     * @Rest\View()
     * @Rest\Get("/user_all")
     */
        public function getUsersAction(){
        $users = $this->getDoctrine()->getRepository('SunuClientBundle:Client')->findAll();
            return $users;
            
        }

    /**
     * @Rest\View()
     * @Rest\Get("/consulter_profile/{username}")
     */
    public function getInfosUserAction(Request $request){
        $users = $this
        ->getDoctrine()
        ->getRepository('SunuUserBundle:User')
        ->getUserInfos($request->get('username'));

        return $users;
            
        }

    /**
     * @Rest\View()
     * @Rest\Delete("/supp_compte/{username}")
     */
    public function getDeleteUserAction(Request $request){
        $users = $this
        ->getDoctrine()
        ->getRepository('SunuUserBundle:User')
        ->findOneByUsername($request->get('username'));
        if(!$users)
        {
            return 'numero inexistant';
        }
        else
        {
            $compte= $users->getCompte();
            $compte->setStatut('supprime');
            $em = $this->getDoctrine()->getManager();
            $em->persist($compte);
            $em->flush();
            if($em)
                return 'ok';
            else
                return 'non ok';   
        }
        return $users;
            
        }   
    /**
     * @Rest\View()
     * @Rest\Get("/connexion/{username}/{password}")
     */
  
    public function getConnexionAction(Request $request){
        $users = $this->getDoctrine()->getRepository('SunuUserBundle:User')->findOneByUsername($request->get('username'));
        if(!$users)
        {
            return 'numero inexistant';
        }
        else
        {
        //$passwordBDD=$users->getPasswords();
       $encoder = $this->get('security.password_encoder');
       $isPasswordValid = $encoder->isPasswordValid($users, $request->get('password'));

        //$passwordreel=$request->get('password');

        if(!$isPasswordValid)
            return false;
        else
        {
        $em = $this->getDoctrine()->getManager();

            $users->isActiveNow();
            $em->persist($users);
            $em->flush();
            return true; 
        }
             
        }
        }   

    /**
     * @Rest\View()
     * @Rest\Get("/verification_code/{username}/{code}")
     */
  
    public function getVerifcodeAction(Request $request){
        $users = $this->getDoctrine()->getRepository('SunuUserBundle:User')->findOneByUsername($request->get('username'));
       
       $compte=$users->getCompte();
        //On recupere le code secret inscrit dans la base de donnees
        $codeinscriptionBDD=$compte->getCodeinscription(); 
        $code_saisie=$request->get('code');

        if($codeinscriptionBDD==$code_saisie)
        {
        $compte->setStatut('actif');		
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($compte); 	
        $em->flush();
        if($em)
        {
            $users->isActiveNow();
            $em->persist($users);
            $em->flush();
            return 'ok';
        }
        else
        {
            return 'echec';
        }
            
        }
        else
            return 'non ok';   
        }

    /**
     * @Rest\View()
     * @Rest\Get("/recuperer_compte/{username}/{libellesecret}/{secret}")
     */
  
    public function getLastnameAction(Request $request){

        $users = $this->getDoctrine()->getRepository('SunuUserBundle:User')->findOneByUsername($request->get('username'));
        
       $libellesecretBDD=$users->getLibellesecret();
       $secretBDD=$users->getSecret();
       $libellesecret_saisie=$request->get('libellesecret');
       $secret_saisie=$request->get('secret');
        if(!$users)
        {
            return 'numero inexistant';
        }
        else
        {
        if($libellesecret_saisie==$libellesecretBDD && $secret_saisie==$secretBDD)
          return 'ok';
        else
          return 'secret incorrect'; 
        }  
        }

    /**
     * @Rest\View()
     * @Rest\Put("/modifier_compte/{username}")
     */
  
    public function getModinumAction(Request $request){

        $users = $this->getDoctrine()->getRepository('SunuUserBundle:User')->findOneByUsername($request->get('username'));
        
       $libellesecretBDD=$users->getLibellesecret();
       $secretBDD=$users->getSecret();
       $libellesecret_saisie=$request->get('libellesecret');
       $secret_saisie=$request->get('secret');
        if(!$users)
        {
            return 'numero inexistant';
        }
        else
        {
        if($libellesecret_saisie==$libellesecretBDD && $secret_saisie==$secretBDD)
        {
            $users->setUsername($request->get('new_numero'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($users); 	
            $em->flush();
            if($em)
            {
                return 'ok';
            }
            else
            {
                return 'echec';
            }
        }
        else
          return 'secret incorrect'; 
        }  
        }
    /**
     * @Rest\View()
     * @Rest\Put("/reset_password/{username}")
     */
  
    public function getResetpasswordAction(Request $request){

        $users = $this->getDoctrine()->getRepository('SunuUserBundle:User')->findOneByUsername($request->get('username'));
        $users->setPlainPassword($request->get('password'));
        $users->setPassword($request->get('password'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($users);
        if($em){
            $em->flush();
            return 'mis a jour';
        }
       else
       {
           return 'echec';
       }  
    }        
    /**
     * @Rest\View()
     * @Rest\Post("/mobile_inscription")
     */
 
	public function postMobileAuthTokensAction(Request $request)
    {
        $user = new User();
		$user->setEnabled(true);  
		$compte = new Compte();
        
       
		//On cree le formulaire de l'operation 
	
    $form = $this->createForm(UserRestType::class, $user);
	
	$form->submit($request->request->all());
	
	 if (!$form->isValid()) {
		 $toutvabien=false;
            return $form;
			
        }
	  	else
		{
		
             $typedecompte = 'Tailleur'; 
            // $lastname = $form["lastname"]->getData(); 
             $secret = $form["secret"]->getData(); 
             $libellesecret = $form["libellesecret"]->getData(); 
             $nom = $form["nom"]->getData(); 
						
		     $typeCompte = $this->getDoctrine()->getManager()->getRepository('SunuUserBundle:TypeCompte')->findOneByLibelleTypeCompte($typedecompte);
		     $compte->setTypeCompte($typeCompte);
				
		////////////////***********************////////////////
		
		//*************Generation du code d'inscription***********/
	   $codeinscription= $this->generateRandomString(6);
	   $compte->setCodeinscription($codeinscription);
	  // echo  $codeinscription; 
	   //*************Fin Generation du code d'inscription***********/
	   
	   
	   
	   /*****************Definition des Roles***********************/
	 
		switch ($typeCompte->getId()) 
		{
    case 1:
       // On définit uniquement le role ROLE_USER qui est le role de base
        $user->setRoles(array('ROLE_UTILISATEUR'));
        break;
    case 2:
       // On définit uniquement le role ROLE_ADMIN qui est le role de base
        $user->setRoles(array('ROLE_ADMIN'));
        break;
        } 
	    /*****************Fin Definition des Roles***********************/
	   
			
        $em = $this->getDoctrine()->getManager();
        $user->setCompte($compte);
       // $user->setLastname($lastname);
        $user->setLibellesecret($libellesecret);
        $this->sendsms($user->getUsername(),'Voici le code d\'activation votre compte:'.$codeinscription);
        $user->setSecret($secret);
        $user->setNom($nom);       
		$em->persist($user);
        $em->flush();
		  $toutvabien=true;
    }
	return  $toutvabien ; 	
    }  

    function generateRandomString($length)
    {
    $characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0987654321'.time();  //la suite de caractere est concatenee a l'heure courante, mesurée en secondes
    
    //echo $characters;
    $charactersLength = strlen($characters);
    $randomString = '';
      for ($i = $length; $i > 0; $i--)
      {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }

function sendsms($num, $message) 
{
 
 $message = urlencode($message);
 
 $num = urlencode($num);
 
 $url = "41.138.57.243:8002/sms2/index.php?app=webservices&h=573af0a6ee137bb385d52f562e38bb98&u=itechpay&op=pv&to=$num&msg=$message";
 
 exec("wget -O- -q \"$url\"");
 
 }
     
}
