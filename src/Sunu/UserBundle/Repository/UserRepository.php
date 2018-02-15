<?php

namespace Sunu\UserBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
use Doctrine\ORM\EntityRepository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllUser()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
   
        $query = $queryBuilder 
        ->select('u.nom','u.prenom','u.username') 
        ->from ('SunuUserBundle:User','u')
        ->innerJoin('u.compte', 'c')
        ->innerJoin('c.typeCompte', 'tc') 
        ->Where('tc.libelleTypeCompte = :idtypecompte')
        ->setParameter('idtypecompte','Tailleur')
       ;
 
   
   return $query
     ->getQuery()
     ->getResult()
   ;
}

public function getAllUserTop()
{
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();

    $query = $queryBuilder 
    ->select('u.nom','u.prenom','u.username') 
    ->from ('SunuUserBundle:User','u')
    ->innerJoin('u.compte', 'c')
    ->innerJoin('c.typeCompte', 'tc') 
    ->Where('tc.libelleTypeCompte = :idtypecompte')
    ->setParameter('idtypecompte','Tailleur')
    ->setMaxResults(10)
   ;


return $query
 ->getQuery()
 ->getResult()
;
}

public function getAllUserClient()
{
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();

    $query = $queryBuilder 
    ->select('COUNT(c.telephone)')
    ->from ('SunuClientBundle:Client','c')
    ->innerJoin('c.iduser', 'u')
   ;


return $query
 ->getQuery()
 ->getSingleScalarResult()
;
}

//api mobile
public function getAllUser2($username)
{
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();

    $query = $queryBuilder 
    ->select('c.code_inscription') 
    ->from ('SunuUserBundle:Compte','c')
    ->innerJoin('c.user', 'u')
    ->Where('u.username = :numero')
    ->setParameter('numero',$username)
    ->getQuery()
   ;


return $query
 ->getResult()
;
}

//api mobile
public function getUserInfos($username)
{
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();

    $query = $queryBuilder 
    ->select('u.username','u.nom') 
    ->from ('SunuUserBundle:User','u')
    ->Where('u.username = :numero')
    ->setParameter('numero',$username)
    ->getQuery()
   ;


return $query
 ->getResult()
;
}

public function getNb() {
 
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('COUNT(u)')
        ->from ('SunuUserBundle:User','u')
        ->getQuery()
        ;

return $query
->getSingleScalarResult()
;
}
public function getActive()
    {
        // Comme vous le voyez, le délais est redondant ici, l'idéale serait de le rendre configurable via votre bundle
        $delay = new \DateTime();
        $delay->setTimestamp(strtotime('2 minutes ago'));
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('COUNT(u)')
        ->from ('SunuUserBundle:User','u')
            ->where('u.lastActivity > :delays')
            ->setParameter('delays', $delay)
        ;
 
        return $query->getQuery()->getSingleScalarResult();
    }

    public function getUserActive()
    {
        // Comme vous le voyez, le délais est redondant ici, l'idéale serait de le rendre configurable via votre bundle
        $delay = new \DateTime();
        $delay->setTimestamp(strtotime('2 minutes ago'));
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('u.username','u.nom','u.prenom')
        ->from ('SunuUserBundle:User','u')
            ->where('u.lastActivity > :delays')
            ->setParameter('delays', $delay)
        ;
 
        return $query->getQuery()->getResult();
    }
}
