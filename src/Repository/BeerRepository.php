<?php

namespace App\Repository;

use App\Entity\Beer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Beer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beer[]    findAll()
 * @method Beer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeerRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Beer::class);
    }

    // /**
    //  * @return a beer by id
    //  */
    public function findById($value) {
        $beer = $this->createQueryBuilder('beer')
            ->andWhere('beer.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
        return $beer[0];
    }

    // /**
    //  * @return beers by category
    //  */
    public function findByCategory(string $category) {
        return $this->createQueryBuilder('beer')
            ->join('beer.categories', 'category')
            ->where('category.name = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }
}
