<?php

namespace AppBundle\Event\Listener;

use AppBundle\Event\Order\OrderAfterCreate;
use AppBundle\Event\Order\OrderBeforeCreate;
use AppBundle\Service\WarehouseService;

class OrderListener
{

    /**
     *
     * @var WarehouseService
     */
    private $warehouseService;

    public function onBeforeCreate(OrderBeforeCreate $event)
    {
        
    }

    public function onAfterCreate(OrderAfterCreate $event)
    {
        $this->warehouseService->reserveProducts($event->getOrder());
    }

    public function setWarehouseService(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
        return $this;
    }

}
