<?php


namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use app\widgets\filter\Filter;
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

        $sql = '';
        if (!empty($_GET['filter'])) {
            $filter = Filter::getFilter();
            if ($filter) {
                $count = Filter::getCountGroups($filter);
                $sql .= "AND id IN(SELECT product_id FROM attribute_product WHERE attr_id IN ($filter) 
                GROUP BY product_id HAVING COUNT(product_id) = $count)";
            }

        }

        $countTotal = \R::count('products', "category_id IN ($ids) $sql");
        $pagination = new Pagination($page, $perPage, $countTotal);
        $start = $pagination->getStart();

        $products = \R::find('products', "category_id IN ($ids)  $sql LIMIT $start,$perPage");
        if ($this->isAjax()) {
            $this->loadView('filter', compact('products', 'countTotal', 'pagination'));
        }
        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs', 'pagination', 'countTotal'));
    }
}