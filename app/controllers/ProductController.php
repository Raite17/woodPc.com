<?php


namespace app\controllers;


use app\models\Breadcrumbs;
use app\models\Product;

class ProductController extends AppController
{
    public function viewAction()
    {
        $alias = $this->route['alias'];
        $product = \R::findOne('products', "alias = ? AND status = '1'", [$alias]);
        if (!$product) {
            throw  new \Exception("Продукт {$alias} не найден!", 404);
        }
        //хлебные крошки
        $breadCrumbs = Breadcrumbs::getBreadCrumbs($product->category_id,$product->title);
        //получаем связанные товары
        $related = \R::getAll("SELECT * FROM related_products as rp JOIN products as p ON p.id = rp.related_id WHERE rp.product_id = ?", [$product->id]);
        //запись в куки запрошенного товара
        $productModel = new Product();
        $productModel->setRecentlyViewed($product->id);
        //просмотренные товары
        $viewed = $productModel->getRecentlyViewed();
        $recentlyViewed = null;
        if ($viewed) {
            $recentlyViewed = \R::find('products', 'id IN (' . \R::genSlots($viewed) . ') LIMIT 3', $viewed);
        }
        //галерея
        $galleries = \R::findAll('gallery', 'product_id = ?', [$product->id]);
        //Задаем мета данные
        $this->setMeta($product->title, $product->description, $product->keywords);
        //Отправляем во View
        $this->set(compact('product', 'related', 'galleries', 'recentlyViewed','breadCrumbs'));
    }
}