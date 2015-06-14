<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

class WarehouseService
{

    const ID = 'app.warehouse';

    private $container;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    public function __construct($container)
    {
        $this->container = $container;
        $this->entityManager = $container->get('doctrine')->getManager();
    }

    public function getAll()
    {
        return $this->entityManager
                        ->getRepository(\AppBundle\Entity\Warehouse::REPOSITORY)
                        ->findAll();
    }

}
