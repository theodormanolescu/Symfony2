<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Repository\CategoryRepository;

/**
 * Class CategoryFixtures
 *
 * @package AppBundle\DataFixtures\ORM
 */
class CategoryFixtures extends AbstractDataFixture
{
    /**
     * @var int
     */
    private $categoriesCount = 0;
    /**
     * @var array
     */
    private $categories = array(
        'computers' => array('servers', 'desktop',
            'laptops', 'components', 'periferals'),
        'phones and tablets' => array('phones', 'tablets', 'accessories'),
        'appliances' => array('coffe machines', 'washing machines',
            'blenders', 'juicers'),
        'video games' => array('consoles', 'games', 'accessories')
    );


    protected function createAndPersistData()
    {
        foreach ($this->categories as $parent => $children) {
            $parentCategory = $this->createAndPersistCategory($parent);
            foreach ($children as $label) {
                $this->createAndPersistCategory($label, $parentCategory);
            }
        }
    }

    /**
     * @param      $label
     * @param null $parentCategory
     *
     * @return Category
     */
    private function createAndPersistCategory($label, $parentCategory = null)
    {
        $this->categoriesCount ++;
        $category = new Category();
        $category->setLabel($label)->setParentCategory($parentCategory);
        $this->manager->persist($category);
        $this->setReference(
            sprintf('category_%s', $this->categoriesCount),
            $category
        );
        return $category;
    }


    protected function preLoad()
    {
        /* @var $categoryRepository CategoryRepository */
        $categoryRepository = $this->manager->getRepository(Category::REPOSITORY);
        $categoryRepository->deleteAll();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}