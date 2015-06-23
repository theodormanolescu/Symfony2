<?php

namespace AppBundle\Service;

use AppBundle\Entity\ProductStock;
use AppBundle\Entity\Warehouse;
use AppBundle\Entity\Order;

/**
 * Class WarehouseService
 *
 * @package AppBundle\Service
 */
class WarehouseService extends AbstractDoctrineAware
{

    /**
     *
     */
    const ID = 'app.warehouse';

    /**
     * @return \AppBundle\Entity\Warehouse[]|array
     */
    public function getAll()
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('warehouse')
            ->from(Warehouse::REPOSITORY, 'warehouse')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @param $productId
     *
     * @return \AppBundle\Entity\ProductStock[]|array
     */
    public function getProductStocks($productId)
    {
        $stocks = $this->entityManager->
                getRepository(ProductStock::REPOSITORY)
                ->findBy(array('product' => $productId));
        if (empty($stocks)) {
            $this->logger->addNotice(sprintf('No stocks found for product %s', $productId));
        }

        return $stocks;
    }
    public function reserveProducts(Order $order)
    {
    }

}
