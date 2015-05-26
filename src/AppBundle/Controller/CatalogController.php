<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CatalogController
 *
 * @package AppBundle\Controller
 */
class CatalogController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('catalog/index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listCategoriesAction()
    {

        $arguments = array('categories' => $this->getCategories());

        return $this->render('catalog/category/list.html.twig', $arguments);
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function treeCategoriesAction(Request $request)
    {
        $arguments = array('categories' => $this->buildTree($this->getCategories()));
        if ($request->getContentType() === 'json') {
            return new JsonResponse($arguments);
        }

        return $this->render('catalog/category/tree.html.twig', $arguments);
    }
    /**
     * @param $categoryId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function showCategoryAction($categoryId)
    {
        $arguments = array('category' => $this->getCategory($categoryId));

        return $this->render('catalog/category/show.html.twig', $arguments);
    }

    /**
     * @param $categoryId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editCategoryAction($categoryId)
    {
        $arguments = array(
            'category' => $this->getCategory($categoryId),
            'parentCategories' => $this->getCategories(),
        );

        return $this->render('catalog/category/edit.html.twig', $arguments);
    }

    /**
     * @param $categoryId
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function saveCategoryAction($categoryId)
    {
        $arguments = array('categoryId' => $categoryId);

        return $this->redirectToRoute('catalog_category_show', $arguments);
    }

    /**
     * @return mixed
     */
    private function getCategories()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categoryRepository = $entityManager->getRepository(Category::REPOSITORY);
        $categories = $categoryRepository->findAll();

        return $categories;
    }

    /**
     * @param $categoryId
     *
     * @return mixed
     * @throws \Exception
     */
    private function getCategory($categoryId)
    {
        $categories = $this->getCategories();
        if (empty($categories[$categoryId])) {
            throw new \Exception("CategoryId $categoryId does not exist");
        }

        return $categories[$categoryId];
    }

    /**
     * @param array $categories
     * @param null  $parentId
     *
     * @return array
     */
    private function buildTree(array $categories, $parentId = null)
    {
        $tree = array();
        /** @var Category $category */
        foreach ($categories as $category) {
            $parentNode = !$parentId && !$category->getParentCategory();
            $childNode = $parentId && $category->getParentCategory() &&
                $category->getParentCategory()->getId() === $parentId;
            if ($parentNode || $childNode) {
                $children = $this->buildTree($categories, $category->getId());
                $tree[$category->getId()] = array(
                    'category' => $category,
                    'children' => $children
                );
            }
        }
        return $tree;
    }
}
