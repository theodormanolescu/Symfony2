<?php

namespace AppBundle\Service;

use AppBundle\Entity\Category;

/**
 * Class CatalogService
 *
 * @package AppBundle\Service
 */
class CatalogService extends AbstractDoctrineAware
{
    /**
     *
     */
    const ID = 'app.catalog';

    /**
     * @return \AppBundle\Entity\Category[]|array
     */
    public function getCategories()
    {
        return $this->entityManager
            ->getRepository(Category::REPOSITORY)
            ->findAll();
    }
}