<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityRepository;

/**
 * Class ProductRepository
 *
 * @package AppBundle\Repository
 */
class ProductRepository extends EntityRepository
{

    public function deleteAll()
    {
        $this->createQueryBuilder('product')
            ->delete(Product::REPOSITORY)
            ->getQuery()
            ->execute();
    }
}