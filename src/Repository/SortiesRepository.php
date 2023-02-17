<?php

namespace App\Repository;

use App\Entity\Sorties;
use App\Entity\Etats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sorties>
 *
 * @method Sorties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sorties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sorties[]    findAll()
 * @method Sorties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorties::class);
    }

    public function save(Sorties $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sorties $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByNom($keyword)
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.nom LIKE :key')
            ->setParameter('key', '%' . $keyword . '%')->getQuery();

        return $query->getResult();
    }
    public function findByEtat()
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.etats_no_etat != 1')->getQuery();

        return $query->getResult();
    }
    public function findByDateDeb($keyword)
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.datedebut LIKE :key')
            ->setParameter('key', '%' . $keyword . '%')->getQuery();

        return $query->getResult();
    }
    public function findByDateFin($keyword)
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.datecloture LIKE :key')
            ->setParameter('key', '%' . $keyword . '%')->getQuery();

        return $query->getResult();
    }

    public function findAllBasic($keyword)
    {
        $query2 = $this->createQueryBuilder('s')
            ->select('s.id')
            ->from('App\Entity\Sorties', 'sorties')
            ->join('App\Entity\Etats', 'e', 'WITH', 'e = s.etats_no_etat')
            ->where('s.organisateur != :key')
            ->andWhere('e.id != 1')
            ->setParameter('key', $keyword)
            ->getQuery()->getResult();
        $query = $this->createQueryBuilder('s')
            ->select('s')
            ->from('App\Entity\Sorties', 'sorties')
            ->where('s.organisateur = :key')
            ->orWhere('s.id IN (:param)')
            ->setParameter('key', $keyword)
            ->setParameter('param', $query2)
            ->getQuery();
        return $query->getResult();
    }

    /*public function findAvgSFdql(): array
    {
        $em = $this->getEntityManager();
        $dql = "SELECT AVG(s.vote) AS avg
FROM App\Entity\Serie As s
WHERE s.genres LIKE '%Sci-Fi%'";
        $req = $em->createQuery($dql);
        return $req->getOneOrNullResult();
    }*/
//    /**
//     * @return Sorties[] Returns an array of Sorties objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sorties
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
