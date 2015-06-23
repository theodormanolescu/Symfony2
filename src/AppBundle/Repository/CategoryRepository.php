<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;

/**
 * Class CategoryRepository
 *
 * @package AppBundle\Repository
 */
class CategoryRepository extends EntityRepository
{
    /**
     *
     */
    public function deleteAll()
    {
        $this->deleteCategories();
        $this->deleteCategories(false);
    }

    /**
     * @param bool $hasParent
     */
    private function deleteCategories($hasParent = true)
    {
        $queryBuilder = $this->createQueryBuilder('category')
            ->delete(Category::REPOSITORY, 'category');
        if ($hasParent) {
            $queryBuilder->where('category.parentCategory IS NOT NULL');
        }
        $queryBuilder->getQuery()->execute();
    }
}