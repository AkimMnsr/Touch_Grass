<?php

namespace App\Repository;

use App\Entity\Sorties;
use App\Repository\ParticipantsRepository;
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

    //no connected
    public function findByEtat()
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.etats_no_etat != 1')->getQuery();

        return $query->getResult();
    }

    //connected filtre Nom
    public function filtreByNom($keyword,$createby)
    {
        $query2 = $this->createQueryBuilder('s')
            ->where('s.nom LIKE :key')
            ->andWhere('s.etats_no_etat != 1')
            ->setParameter('key', '%' . $keyword . '%')->getQuery()->getResult();

        $query3 = $this->createQueryBuilder('s')
            ->where('s.organisateur = :orga')
            ->andWhere('s.nom LIKE :key')
            ->setParameter('orga',$createby)
            ->setParameter('key','%'.$keyword.'%')->getQuery()->getResult();

        $query = $this->createdByWithSearch($query2,$query3);
        return $query->getResult();
    }

    //connected filtre Site
    public function filtreBySite($keyword,$createby, ParticipantsRepository $pr)
    {
        $query2 = $this->findBy([
            'organisateur'=>$pr->findBy([
                'sites_no_site' => $keyword
            ]),
            'etats_no_etat'=>$this->findByEtat()
        ]);

        $query3 = $this->findBy([
            'organisateur' => $pr->findBy([
                'id' => $createby,
                'sites_no_site' =>$keyword
            ])
        ]);
        $query = $this->createdByWithSearch($query2,$query3);
        return $query->getResult();
    }

    //connected filtre date deb
    public function filtreByDateDeb($keyword,$createby)
    {
        $query2 = $this->createQueryBuilder('s')
            ->where('s.datedebut LIKE :key')
            ->andWhere('s.etats_no_etat != 1')
            ->setParameter('key', '%' . $keyword . '%')->getQuery()->getResult();

        $query3 = $this->createQueryBuilder('s')
            ->where('s.organisateur = :orga')
            ->andWhere('s.datedebut LIKE :key')
            ->setParameter('orga',$createby)
            ->setParameter('key','%'.$keyword.'%')->getQuery()->getResult();

        $query = $this->createdByWithSearch($query2,$query3);
        return $query->getResult();
    }

    //connected filtre date fin
    public function filtreByDateFin($keyword,$createby)
    {
        $query2 = $this->createQueryBuilder('s')
            ->where('s.datecloture LIKE :key')
            ->andWhere('s.etats_no_etat != 1')
            ->setParameter('key', '%' . $keyword . '%')->getQuery()->getResult();

        $query3 = $this->createQueryBuilder('s')
            ->where('s.organisateur = :orga')
            ->andWhere('s.datecloture LIKE :key')
            ->setParameter('orga',$createby)
            ->setParameter('key','%'.$keyword.'%')->getQuery()->getResult();

        $query = $this->createdByWithSearch($query2,$query3);
        return $query->getResult();
    }

    //connected nofiltre
    public function findAllNoFiltre($keyword)
    {
        $query2 = $this->createQueryBuilder('s')
            ->from('App\Entity\Sorties', 'sorties')
            ->where('s.organisateur != :key')
            ->andWhere('s.etats_no_etat != 1')
            ->setParameter('key', $keyword)
            ->getQuery()->getResult();

        $query = $this->createQueryBuilder('s')
            ->from('App\Entity\Sorties', 'sorties')
            ->where('s.organisateur = :key')
            ->orWhere('s.id IN (:param)')
            ->setParameter('key', $keyword)
            ->setParameter('param', $query2)
            ->getQuery();
        return $query->getResult();
    }


    public function createdByWithSearch($query2,$query3){
        $query = $this->createQueryBuilder('s')
            ->from('App\Entity\Sorties', 'sorties')
            ->where('s.id IN (:verif)')
            ->orWhere('s.id IN (:param)')
            ->setParameter('verif',$query3)
            ->setParameter('param', $query2)
            ->getQuery();
        return $query;
    }
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
