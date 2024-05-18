<?php

namespace App\Repository;

use App\Entity\ImageM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageM>
 *
 * @method ImageM|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageM|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageM[]    findAll()
 * @method ImageM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageM::class);
    }

//    /**
//     * @return ImageM[] Returns an array of ImageM objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImageM
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
