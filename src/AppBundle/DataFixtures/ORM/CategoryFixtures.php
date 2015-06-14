<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends AbstractFixture
{

    private $manager;
    private $categories = array(
        'computers' => array('servers', 'desktop', 'laptops', 'components', 'periferals'),
        'phones and tablets' => array('phones', 'tablets', 'accessories'),
        'appliances' => array('coffe machines', 'washing machines', 'blenders', 'juicers'),
        'video games' => array('consoles', 'games', 'accessories')
    );

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->createAndPersistCategories();
        $this->manager->flush();
    }

    private function createAndPersistCategories()
    {
        foreach ($this->categories as $parent => $children) {
            $parentCategory = $this->createAndPersistCategory($parent);
            foreach ($children as $label) {
                $this->createAndPersistCategory($label, $parentCategory);
            }
        }
    }

    private function createAndPersistCategory($label, $parentCategory = null)
    {
        $category = new Category();
        $category->setLabel($label)->setParentCategory($parentCategory);
        $this->manager->persist($category);

        return $category;
    }

}