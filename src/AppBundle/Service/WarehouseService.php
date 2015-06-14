<?php

namespace AppBundle\Service;

use AppBundle\Entity\ProductStock;
use AppBundle\Entity\Warehouse;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;

class WarehouseService
{

    const ID = 'app.warehouse';

    private $doctrine;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $doctrine->getManager();
    }

    public function getAll()
    {
        return $this->entityManager
                        ->getRepository(Warehouse::REPOSITORY)
                        ->findAll();
    }

    public function getProductStocks($productId)
    {
        return $this->entityManager->
                        getRepository(ProductStock::REPOSITORY)
                        ->findBy(array('product' => $productId));
    }

}
