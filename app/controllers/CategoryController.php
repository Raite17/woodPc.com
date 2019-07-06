<?php


namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use woodpc\App;
use woodpc\libs\Pagination;

class CategoryController extends AppController
{
    public function viewAction()
    {
        $alias = $this->route['alias'];
        $category = \R::findOne('category', 'alias = ?', [$alias]);
        if (!$category) {
            throw new \Exception('Страница не найдена!', 404);
        }
        $breadcrumbs = Breadcrumbs::getBreadCrumbs($category->id);
        $categoryModel = new Category();
        $ids = $categoryModel->getIds($category->id);
        $ids = !$ids ? $category->id : $ids . $category->id;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = App::$app->getProperty('pagination');
        $countTotal = \R::count('products', "category_id IN ($ids)");
        $pagination = new Pagination($page, $perPage, $countTotal);
        $start = $pagination->getStart();
        $products = \R::find('products', "category_id IN ($ids) LIMIT $start,$perPage");
        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs', 'pagination', 'countTotal'));
    }
}