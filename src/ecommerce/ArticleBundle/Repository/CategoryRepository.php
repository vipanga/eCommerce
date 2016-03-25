<?php

namespace ecommerce\ArticleBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    public function getCategories() {

        // La construction de la requête reste inchangée
        $query = $this->createQueryBuilder('c')
                ->leftJoin('c.genres', 'gen')
                ->addSelect('gen')
                ->getQuery();

        return $query->getResult();
    }
}