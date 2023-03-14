<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * 
 */
class StatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    
    // find sum by presence / bench / items NM / items HM / items Contested

    public function findSumNbPresence(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT COUNT(pa.isBench) AS nbPresence
            FROM App\Entity\Participation pa
            WHERE pa.isBench = 0
            '
        );

        return $query->getResult();
    }

    public function findSumNbBench(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT AVG(pa.isBench) AS nbBench
            FROM App\Entity\Participation pa
            JOIN App\Entity\Player pl
            WHERE pa.isBench = 1
            '
        );

        return $query->getResult();
    }

    public function findSumNbItemNMB(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT AVG('NM') AS nbItemNM 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\item i WITH lh.item = i.id
            WHERE i.type = 'NM'
            "
        );

        return $query->getResult();
    }


    public function findSumNbItemHMB(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT AVG('HM') AS nbItemHM 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\item i WITH lh.item = i.id
            WHERE i.type = 'HM'
            "
        );

        return $query->getResult();
    }

    public function findSumNbItemContested(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT AVG('Contested') AS nbItemContested 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\item i WITH lh.item = i.id
            WHERE i.type = 'Contested'
            "
        );

        return $query->getResult();
    }
}