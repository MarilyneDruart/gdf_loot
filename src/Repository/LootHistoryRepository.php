<?php

namespace App\Repository;

use App\Entity\LootHistory;
use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LootHistory>
 *
 * @method LootHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method LootHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method LootHistory[]    findAll()
 * @method LootHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LootHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LootHistory::class);
    }

    public function add(LootHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LootHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLootHistory($slug): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT p.slug, r.name AS raid, e.date,i.name AS item, i.type 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\Event e WITH lh.event = e.id 
            JOIN App\Entity\Player p WITH lh.player = p.id 
            JOIN App\Entity\Item i WITH lh.item = i.id 
            JOIN App\Entity\Raid r WITH i.raid = r.id
            WHERE p.slug = '$slug'
            "
        );

        return $query->getResult();
    }
}
