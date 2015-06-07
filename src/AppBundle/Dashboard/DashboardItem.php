<?php

namespace AppBundle\Dashboard;

class DashboardItem
{

    private $key;
    private $title;
    private $route;
    private $icon;
    private $active;

    public function getKey()
    {
        return $this->key;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

}
