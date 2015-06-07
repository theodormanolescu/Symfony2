<?php

namespace AppBundle\Dashboard;

class Dashboard
{

    private $items = array();

    public function addItems(DashboardItem $item)
    {
        $this->items[$item->getKey()] = $item;
    }

    public function getItems($includeInactive = false)
    {
        $items = array();
        foreach ($this->items as $item) {
            if ($item->isActive() || $includeInactive) {
                $items[] = $item;
            }
        }
        return $items;
    }

    public function loadFromConfiguration($configuration)
    {
        foreach ($configuration['dashboard']['items'] as $key => $item) {
            $title = $item['title'] ? $item['title'] : $key;
            $icon = $item['icon'] ? $item['icon'] : 'default.png';
            $dashboardItem = new DashboardItem();
            $dashboardItem
                    ->setKey($key)
                    ->setActive($item['active'])
                    ->setTitle($title)
                    ->setRoute($item['route'])
                    ->setIcon($icon);
            $this->items[$dashboardItem->getKey()] = $dashboardItem;
        }
    }

}
