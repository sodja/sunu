<?php

namespace Sunu\ClientBundle\Controller;

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

class ClientRestController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Post("/mobile_enregistrement_client")
     */
    public function postClientAction(Request $request)
    {
        $users = $this->getDoctrine()->getRepository('SunuUserBundle:User')->findOneByUsername($request->get('username'));
        if($users)
        {
           //return $users->getId();
            $client = new Client();

            $numeroclient=$request->get('telephone');

            $verifclient= $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SunuClientBundle:Client')
            ->getSuppClientParTailleur($users->getId(),$numeroclient);

            if(!$verifclient)
            {
            $client->setNom($request->get('nom'));
            $client->setPrenom($request->get('prenom'));
            $client->setTelephone($request->get('telephone'));
            $client->setAdresse($request->get('adresse'));
            $client->setIdUser($users);

            $em=$this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush(); 	

            if($em)
            {
                return 'ok';
            }
            else
            {
                return 'non_ok';
            }                
          }
          else
           return 'client existe';
        }
            
        
    }  

    /**
     * @Rest\View()
     * @Rest\Get("/liste_client/{username}")
     */
    public function getClientByUserAction(Request $request)
        {
            $user=$this->getDoctrine()->getRepository("SunuUserBundle:User")->findOneByUsername($request->get('username'));
            if(!$user)
            {
                return 'numero innexistant';
            }
            else
            {
                $listeclient= $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SunuClientBundle:Client')
                ->getClientParTailleur($user->getId())
                ;
                return $listeclient;
            }
        }

    /**
     * @Rest\View()
     * @Rest\Delete("/supprimer_client/{username}/{numeroclient}")
     */
    public function deleteUserByClientAction(Request $request)
        {
            $user=$this->getDoctrine()->getRepository("SunuUserBundle:User")->findOneByUsername($request->get('username'));
            if(!$user)
            {
                return 'numero innexistant';
            }
            else
            {
                $numeroclient=$request->get('numeroclient');
                $telclient= $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SunuClientBundle:Client')
                ->getSuppClientParTailleur($user->getId(),$numeroclient)
                ;
                $client=$this->getDoctrine()->getRepository("SunuClientBundle:Client")->findOneByTelephone($request->get('numeroclient'));
                $client->setStatut('supprimer');

                $em=$this->getDoctrine()->getManager();
                $em->persist($client);
                $em->flush();
                if($em)
                {
                    return 'ok';
                }
                else{
                    return 'non ok';
                }
              // return $client;
            
            }
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
}
