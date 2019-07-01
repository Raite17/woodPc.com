<?php


namespace app\controllers;


class ProductController extends AppController
{
    public function viewAction()
    {
        $alias = $this->route['alias'];
        $product = \R::findOne('products', "alias = ? AND status = '1'", [$alias]);
        if (!$product) {
            throw  new \Exception("Продукт {$alias} не найден!", 404);
        }
        //breadcrumbs
        //related_products
        $related = \R::getAll("SELECT * FROM related_products as rp JOIN products as p ON p.id = rp.related_id WHERE rp.product_id = ?",[$product->id]);
        //Запись в куки текущего товара
        //Просмотренные товары
        //Галерея
        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->set(compact('product','related'));
    }
}