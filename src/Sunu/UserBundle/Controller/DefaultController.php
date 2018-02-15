<?php

namespace Sunu\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sunu\UserBundle\Entity\User;

class DefaultController extends Controller
{

    public function indexAction()
    {
                $em = $this->getDoctrine()->getManager();




        $users = $this->getDoctrine()->getManager()->getRepository('SunuUserBundle:User')->getActive();
        return $this->render('SunuUserBundle:Default:index.html.twig');
    }

    public function listeutilisateurAction()
    {
        $listeuser = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('SunuUserBundle:User')
        ->getAllUser()
        ;
        return $this->render('SunuUserBundle:user:listeuser.html.twig',array('listeusers' =>$listeuser));
    }

    public function listeutilisateurConnecterAction()
    {
        $listeuser = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('SunuUserBundle:User')
        ->getUserActive()
        ;
        return $this->render('SunuUserBundle:user:listeuserconnect.html.twig',array('listeusers' =>$listeuser));
    }

    public function accueilAction()
    { 
        $users = $this->getDoctrine()->getManager()->getRepository('SunuUserBundle:User')->getActive();

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->isActiveNow();
        $em->persist($user);
        $em->flush();     
           
        $nbreuser = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('SunuUserBundle:User')
        ->getNb()
        ;

        $nbreclient = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('SunuClientBundle:Client')
        ->getAllUserClient()
        ;

        $compte = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('SunuUserBundle:User')
        ->getAllUserTop()
        ;
        return $this->render('SunuUserBundle:Default:index.html.twig',array('nbreuser' =>$nbreuser,'user' =>$compte,'nbrecl'=>$nbreclient,'users' =>$users));
    }

    public function infoUsersAction()
    { 
        $users = $this->getDoctrine()->getManager()->getRepository('SunuUserBundle:User')->getActive();    
           

        $listeuser = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('SunuUserBundle:User')
        ->getUserActive()
        ;
        return $this->render('SunuUserBundle:user:infosuser.html.twig',array('listeusers' =>$listeuser));
    }
}
