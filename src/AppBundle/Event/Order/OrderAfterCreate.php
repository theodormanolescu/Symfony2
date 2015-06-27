<?php

namespace AppBundle\Event\Order;

use AppBundle\Entity\Order;
use AppBundle\Event\LoggableEventInterface;

class OrderAfterCreate extends OrderEvent implements LoggableEventInterface
{

    /**
     *
     * @var Order
     */
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getLogContext()
    {
        return array('id' => $this->order->getId());
    }

}
