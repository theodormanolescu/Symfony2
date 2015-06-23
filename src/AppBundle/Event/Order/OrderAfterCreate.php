<?php
namespace AppBundle\Event\Order;
use AppBundle\Entity\Order;

/**
 * Class OrderAfterCreate
 *
 * @package AppBundle\Event\Order
 */
class OrderAfterCreate extends OrderEvent
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

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}