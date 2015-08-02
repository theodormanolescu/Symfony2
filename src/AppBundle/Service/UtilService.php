<?php

namespace AppBundle\Service;

use AppBundle\Exception\LockException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Monolog\Logger;

class UtilService
{

    const ID = 'app.util';

    /**
     *
     * @var RegistryInterface
     */
    private $registry;

    /**
     *
     * @var Logger
     */
    private $logger;
    
    private $prefix;

    function __construct(RegistryInterface $registry, Logger $logger, $prefix = 'app.') {
        $this->registry = $registry;
        $this->logger = $logger;
        $this->prefix = $prefix;
    }

    public function getLock($lock, $timeout = 10) {
        $lock = $this->prefix.$lock;
        $this->logger->addInfo(sprintf('acquiring named lock "%s"', $lock));
        $connection = $this->registry->getConnection();
        $result = $connection->executeQuery(
            "SELECT GET_LOCK(':lock', :timeout)", array('lock' => $lock, 'timeout' => $timeout)
        );
        if (!$result) {
            throw new LockException(sprintf('Cannot get named lock %s', $lock));
        }
        $this->logger->addInfo(sprintf('acquired named lock "%s"', $lock));
    }

    public function releaseLock($lock) {
        $lock = $this->prefix.$lock;
        $connection = $this->registry->getConnection();
        $connection->executeQuery(
                "SELECT RELEASE_LOCK(':lock')", array('lock' => $lock)
        );
        $this->logger->addInfo(sprintf('released named lock "%s"', $lock));
    }

}
