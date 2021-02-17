<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    public function findByName($name, $limit = 10)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.name = :val')
            ->setParameter('val', $name)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return all categories from normals or specials
    //  */
    public function findByTerm($term)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.term = :term')
            ->setParameter('term', $term)
            ->getQuery()
            ->getResult()
        ;
    }


    // /**
    //  * @return une bière par rapport à ses relations via l'ORM sans passer par SQL
    //  */
    public function findCatSpecial(int $id)
    {
        return $this->createQueryBuilder('category')
            ->join('category.beers', 'beer') // raisonner en terme de relation
            ->where('beer.id = :id')
            ->setParameter('id', $id)
            ->andWhere('category.term = :term')
            ->setParameter('term', 'special')
            ->getQuery()
            ->getResult();
    }
}
