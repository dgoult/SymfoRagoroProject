<?php

namespace App\Repository;

use App\Entity\CommentaireCours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommentaireCours>
 *
 * @method CommentaireCours|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireCours|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireCours[]    findAll()
 * @method CommentaireCours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireCourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentaireCours::class);
    }

    public function save(CommentaireCours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CommentaireCours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CommentaireCour[] Returns an array of CommentaireCour objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findCommentaireByCoursId($id): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.cours = :coursId')
            ->orderBy('c.date_creation')
            ->setParameter('coursId', $id)
            ->getQuery()
            ->getResult()
        ;
    }
}
