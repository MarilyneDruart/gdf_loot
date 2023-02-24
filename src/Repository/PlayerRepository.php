<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Player>
 *
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function add(Player $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Player $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPlayersByName(string $query)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('p.name', ':query'),
                    ),
                )
            )
            ->setParameter('query', '%' . $query . '%')
        ;
        return $qb
            ->getQuery()
            ->getResult();
    }

    public function findPlayerByRank(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p.rank, COUNT(p)
            FROM App\Entity\Player p
            GROUP BY p.rank
            '
        );

        return $query->getResult();
    }

    public function findPlayerByRole(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r.name, COUNT(p) 
            FROM App\Entity\Player p 
            JOIN App\Entity\Role r
            WHERE p.role = r.id 
            GROUP BY p.role
            '
        );

        return $query->getResult();
    }

    public function findPlayerByParticipation(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT pl.name, COUNT(pa.isBench) 
            FROM App\Entity\Participation pa
            JOIN App\Entity\Player pl
            WHERE pa.player = pl.id
            AND pa.isBench = 0
            GROUP BY pl.name
            ORDER BY COUNT(pa.isBench) DESC
            '
        )->setMaxResults(5);

        return $query->getResult();
    }

    public function findPlayerByBench(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT pl.name, COUNT(pa.isBench) 
            FROM App\Entity\Participation pa
            JOIN App\Entity\Player pl
            WHERE pa.player = pl.id 
            AND pa.isBench = 1
            GROUP BY pl.name
            ORDER BY COUNT(pa.isBench) DESC
            '
        )->setMaxResults(5);

        return $query->getResult();
    }

    public function sortByScore(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT pl
            FROM App\Entity\Player pl
            ORDER BY pl.score DESC
            '
        );

        return $query->getResult();
    }

    public function findNbItemNMByPlayer(int $playerId): array
    {
        $entityManager = $this->getEntityManager();
    
        $query = $entityManager->createQuery(
            "SELECT COUNT('NM') AS nbItemNM 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\item i WITH lh.item = i.id
            WHERE i.type = 'NM' AND lh.player = :player"
        );
        
        $query->setParameter('player', $playerId);
    
        return $query->getResult();
    }

    public function findNbItemHMByPlayer(int $playerId): array
    {
        $entityManager = $this->getEntityManager();
    
        $query = $entityManager->createQuery(
            "SELECT COUNT('HM') AS nbItemHM 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\item i WITH lh.item = i.id
            WHERE i.type = 'HM' AND lh.player = :player"
        );
        
        $query->setParameter('player', $playerId);
    
        return $query->getResult();
    }

    public function findNbItemContestedByPlayer(int $playerId): array
    {
        $entityManager = $this->getEntityManager();
    
        $query = $entityManager->createQuery(
            "SELECT COUNT('Contested') AS nbItemContested 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\item i WITH lh.item = i.id
            WHERE i.type = 'Contested' AND lh.player = :player"
        );
        
        $query->setParameter('player', $playerId);
    
        return $query->getResult();
    }


}