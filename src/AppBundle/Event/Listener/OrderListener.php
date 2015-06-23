<?php
namespace AppBundle\Event\Listener;

use AppBundle\Event\Order\OrderAfterCreate;
use AppBundle\Event\Order\OrderBeforeCreate;
use AppBundle\Service\AbstractDoctrineAware;
use AppBundle\Service\WarehouseService;

/**
 * Class OrderListener
 *
 * @package AppBundle\Event\Listener
 */
class OrderListener extends AbstractDoctrineAware
{
    /** @var WarehouseService */
    private $warehouseService;

    /**
     * @param OrderBeforeCreate $event
     */
    public function onBeforeCreate(OrderBeforeCreate $event)
    {
        $this->logger->addInfo(
            'Creating order', array(
            'customerId' => $event->getCustomerId(),
            'products' => $event->getProducts()
        ));
    }

    /**
     * @param OrderAfterCreate $event
     */
    public function onAfterCreate(OrderAfterCreate $event)
    {
        $this->logger->addInfo(
            'Order created', array('orderId' => $event->getOrder()->getId())
        );
        $this->warehouseService->reserveProducts($event->getOrder());
    }

    /**
     * @param WarehouseService $warehouseService
     *
     * @return $this
     */
    public function setWarehouseService(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
        return $this;
    }
}