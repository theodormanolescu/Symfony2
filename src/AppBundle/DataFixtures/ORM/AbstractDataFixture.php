<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AbstractDataFixture
 *
 * @package AppBundle\DataFixtures\ORM
 */
abstract class AbstractDataFixture extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var
     */
    protected $manager;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->createAndPersistData();
        $this->manager->flush();
    }

    /**
     * @return mixed
     */
    abstract protected function createAndPersistData();
}