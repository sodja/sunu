<?php
# Sunu\UserBundle\Listener\ActivityListener.php

namespace Sunu\UserBundle\Listener;
 
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\User\UserInterface;
 
class ActivityListener
{
    protected $context;
    protected $em;
 
    public function __construct(SecurityContext $context, EntityManager $manager)
    {
        $this->context = $context;
        $this->em = $manager;
    }
 
    /**
    * Update the user "lastActivity" on each request
    * @param FilterControllerEvent $event
    */
    public function onCoreController(FilterControllerEvent $event)
    {
        // ici nous vérifions que la requête est une "MASTER_REQUEST" pour que les sous-requête soit ingoré (par exemple si vous faites un render() dans votre template)
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }
 
        // Nous vérifions qu'un token d'autentification est bien présent avant d'essayer manipuler l'utilisateur courant.
        if ($this->context->getToken()) {
            $user = $this->context->getToken()->getUser();
 
            // Nous utilisons un délais pendant lequel nous considèrerons que l'utilisateur est toujours actif et qu'il n'est pas nécessaire de refaire de mise à jour
            $delay = new \DateTime();
            $delay->setTimestamp(strtotime('2 minutes ago'));
 
            // Nous vérifions que l'utilisateur est bien du bon type pour ne pas appeler getLastActivity() sur un objet autre objet User
            if ($user instanceof User && $user->getLastActivity() < $delay) {
                $user->isActiveNow();
              // $user->setConnexion(1);
                $this->em->flush($user);
            }
            else
            $user->setConnexion(0);
        }
    }
}