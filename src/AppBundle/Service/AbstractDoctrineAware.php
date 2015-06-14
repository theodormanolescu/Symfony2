<?php

namespace AppBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;

class AbstractDoctrineAware
{
    const ID = 'app.doctrine_aware';
    
    /**
     *
     * @var Registry
     */
    protected $doctrine;
    /**
     *
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $doctrine->getManager();
    }
}
