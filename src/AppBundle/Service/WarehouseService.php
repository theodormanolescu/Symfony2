<?php

namespace AppBundle\Service;

use AppBundle\Entity\ProductStock;
use AppBundle\Entity\Warehouse;
use AppBundle\Exception\AppException;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class WarehouseService
 *
 * @package AppBundle\Service
 */
class WarehouseService extends AbstractDoctrineAware
{
    const ID = 'app.warehouse';

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->entityManager
            ->getRepository(Warehouse::REPOSITORY)
            ->findAll();
    }

    /**
     * @param $productId
     *
     * @return mixed
     */
    public function getProductStocks($productId)
    {
        $stocks = $this->entityManager->
        getRepository(ProductStock::REPOSITORY)
            ->findBy(array('product' => $productId));
        if (empty($stocks)) {
            $this->logger->addNotice(
                sprintf('No stocks found for product %s', $productId)
            );
        }
        return $stocks;
    }


    /**
     * @param int $productId
     * @param int $quantity
     * @param int $fromWarehouseId
     * @param int $toWarehouseId
     *
     * @throws AppException
     */
    public function moveProductStock($productId, $quantity, $fromWarehouseId, $toWarehouseId)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;
        if (empty($productId) && empty($quantity) && empty($fromWarehouseId)&& empty($toWarehouseId)) {
            throw new AppException("All parameters are mandatory");
        }
        /** @var ProductStock $product */
        $product = $em
            ->getRepository(ProductStock::REPOSITORY)
            ->findBy(array('product' => $productId));
        if (is_null($product)) {
            throw new AppException("No product available for the following id: $productId");
        }
        /** @var Warehouse $oldWarehouse */
        $oldWarehouse = $em
            ->getRepository(Warehouse::REPOSITORY)
            ->find($fromWarehouseId);
        /** @var Warehouse $oldWarehouse */
        $newWarehouse = $em
            ->getRepository(Warehouse::REPOSITORY)
            ->find($toWarehouseId);

        if ((is_null($oldWarehouse)) && ($product->getWarehouse() !== $oldWarehouse)) {
            throw new AppException("The current warehouse does not match or is not set");
        }
        if ($quantity > 0) {
            $product
                ->setQuantity($quantity)
                ->setWarehouse($newWarehouse);
            $em->persist($product);
            try {
                $em->flush();
            } catch (\Exception $e) {
                $this->logger->log(Logger::ERROR, $e->getMessage());
                throw new AppException('Problem moving stock');
            }
        } else {
            return false;
        }
    }

    /**
     * Get entity repository
     * @param null $entity
     * @param null $manager
     * @return \Doctrine\ORM\EntityRepository|mixed
     * @throws AppException
     */
    public function getRepository($entity = null, $manager = null)
    {
        if (is_null($entity)) {
            throw new AppException('Entity name has to be provided');
        }

        return $this
            ->doctrine
            ->getManager($manager)
            ->getRepository($entity);
    }
}
