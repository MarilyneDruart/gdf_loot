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

}