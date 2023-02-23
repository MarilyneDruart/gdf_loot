<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Item;
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

    public function findLootHistoryBySlug($slug): array
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

    public function findNbPresenceBySlug($slug): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT COUNT(pa.player) AS nombre 
            FROM App\Entity\Participation pa 
            JOIN App\Entity\Player pl WHERE pa.player = pl.id
            AND pa.isBench = 0
            AND pl.slug = '$slug'
            "
        );

        return $query->getResult();
    }

    public function findNbBenchBySlug($slug): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT COUNT(pa.player) AS nombre 
            FROM App\Entity\Participation pa 
            JOIN App\Entity\Player pl WHERE pa.player = pl.id
            AND pa.isBench = 1
            AND pl.slug = '$slug'
            "
        );

        return $query->getResult();
    }

    public function findNbItemNMBySlug($slug): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT COUNT(lh.item) AS nombre 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\Player pl WITH lh.player = pl.id
            AND pl.slug = '$slug'
            JOIN App\Entity\Item it WITH lh.item = it.id
            AND it.type = 'NM'
            "
        );

        return $query->getResult();
    }

    public function findNbItemHMBySlug($slug): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT COUNT(lh.item) AS nombre 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\Player pl WITH lh.player = pl.id
            AND pl.slug = '$slug'
            JOIN App\Entity\Item it WITH lh.item = it.id
            AND it.type = 'HM'
            "
        );

        return $query->getResult();
    }

    public function findNbItemContestedBySlug($slug): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT COUNT(lh.item) AS nombre 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\Player pl WITH lh.player = pl.id
            AND pl.slug = '$slug'
            JOIN App\Entity\Item it WITH lh.item = it.id
            AND it.type = 'Contested'
            "
        );

        return $query->getResult();
    }

    public function calculScoreBySlug(LootHistoryRepository $lootHistoryRepository, string $slug)
    {
        $nbPresences = $lootHistoryRepository->findNbPresenceBySlug($slug);
        $nbBenches = $lootHistoryRepository->findNbBenchBySlug($slug);
        $nbItemNM = $lootHistoryRepository->findNbItemNMBySlug($slug);
        $nbItemHM = $lootHistoryRepository->findNbItemHMBySlug($slug);
        $nbItemContested = $lootHistoryRepository->findNbItemContestedBySlug($slug);

        $scoreContested = $nbItemContested[0]['nombre'] * 2;
        $scoreItemNM = $nbItemNM[0]['nombre'] * 0.8;
        $scoreItemHM = $nbItemHM[0]['nombre'] * 1;
        $scoreBis = $scoreItemNM + $scoreItemHM;
        if ($nbBenches[0]['nombre'] == 0 && $nbPresences[0]['nombre'] == 0)
        {
            $scorePresence = 1;
        } else {
            $scorePresence = $nbBenches[0]['nombre'] + $nbPresences[0]['nombre'];
        } 

        $scores = ($scoreContested + $scoreBis) / $scorePresence;

        return number_format($scores, 3);
    }

    public function setCalculScoreBySlug(string $slug, float $scores)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "UPDATE App\Entity\Player pl
            SET pl.score = '$scores'
            WHERE pl.slug = '$slug'
            "
        );

        return $query->getResult();
    }

    public function findNbItemNM(int $playerId): array
    {
        $entityManager = $this->getEntityManager();
    
        $query = $entityManager->createQuery(
            "SELECT COUNT('*') AS sumItemsNM 
            FROM App\Entity\LootHistory lh 
            JOIN App\Entity\Player p 
            WITH p.id = lh.player
            JOIN App\Entity\item i
            WITH lh.item = i.id
            WHERE i.type = 'NM' AND p.id = :playerId"
        )->setParameter('playerId', $playerId);
    
        return $query->getResult();
    }
    

    public function findNbItemHM(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT COUNT('HM') AS sumItemsHM 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\item i
            WITH lh.item = i.id
            WHERE i.type = 'HM' AND lh.player = 13
            "
        );

        return $query->getResult();
    }

    public function findNbItemContested(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT COUNT('Contested') AS sumItemsContested 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\item i
            WITH lh.item = i.id
            WHERE lh.player = 13 AND i.type = 'Contested'
            "
        );

        return $query->getResult();
    }
}
