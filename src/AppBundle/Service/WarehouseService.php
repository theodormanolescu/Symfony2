<?php

namespace AppBundle\Service;

use AppBundle\Entity\Order;
use AppBundle\Entity\ProductStock;
use AppBundle\Entity\Warehouse;
use AppBundle\Event\Order\OrderEvent;

class WarehouseService extends AbstractDoctrineAware
{

    const ID = 'app.warehouse';

    /**
     *
     * @var UtilService
     */
    private $utilService;

    function setUtilService(UtilService $utilService) {
        $this->utilService = $utilService;
    }

    public function getAll() {
        return $this->entityManager
                        ->createQueryBuilder()
                        ->select('warehouse')
                        ->from(Warehouse::REPOSITORY, 'warehouse')
                        ->getQuery()
                        ->getArrayResult();
    }

    public function getProductStocks($productId) {
        $stocks = $this->entityManager->
                getRepository(ProductStock::REPOSITORY)
                ->findBy(array('product' => $productId));
        if (empty($stocks)) {
            return array();
        }

        return $stocks;
    }

    public function reserveProducts(Order $order) {
        $lockName = 'reserve_products';
        $this->utilService->getLock($lockName);
        try {
            if ($this->checkProductsStock($order)) {
                $this->doReserveProducts($order);
                $this->eventDispatcher->dispatch(
                        OrderEvent::PRODUCTS_RESERVED, new OrderEvent($order)
                );
            } else {
                $this->eventDispatcher->dispatch(
                        OrderEvent::PRODUCTS_RESERVATION_FAILED, new OrderEvent($order)
                );
            }
        } finally {
            $this->utilService->releaseLock($lockName);
        }
    }

    private function doReserveProducts(Order $order) {
        
    }

    private function checkProductsStock(Order $order) {
        $quantities = array();
        foreach ($order->getProductLines() as $productLine) {
            $quantities[$productLine->getProductSale()->getProduct()->getId()] = $productLine->getQuantity();
        }
        $productStocks = $this->getProductStocksByProductIds(array_keys($quantities))->execute();
        foreach ($productStocks as $productStock) {
            $id = $productStock->getProduct()->getId();
            if ($quantities[$id] <= $productStock->getQuantity()) {
                unset($quantities[$id]);
            }
        }
        return empty($quantities);
    }

    public function getProductStocksByProductIds(array $productIds) {
        return $this->entityManager
                        ->createQueryBuilder()
                        ->select('productStock')
                        ->from(ProductStock::REPOSITORY, 'productStock')
                        ->where('productStock.product in (:products)')
                        ->setParameter('products', $productIds)
                        ->getQuery();
    }

    public function packageProducts(Order $order) {
        $this->eventDispatcher->dispatch(OrderEvent::PACKAGING_START, new OrderEvent($order));
        $this->eventDispatcher->dispatch(OrderEvent::PACKAGING_END, new OrderEvent($order));
    }

}
