<?php


namespace app\controllers;

use app\models\Category;

class CategoryController extends AppController
{
    public function viewAction()
    {
        $alias = $this->route['alias'];
        $category = \R::findOne('category', 'alias = ?', [$alias]);
        if (!$category) {
            throw new \Exception('Страница не найдена!', 404);
        }
        //breadcrumbs
        $breadcrumbs = '';
        $categoryModel = new Category();
        $ids = $categoryModel->getIds($category->id);
        $ids = !$ids ? $category->id : $ids . $category->id;
        $products = \R::find('products', "category_id IN ($ids)");
        $this->setMeta($category->title,$category->description,$category->keywords);
        $this->set(compact('products','breadcrumbs'));
    }
}