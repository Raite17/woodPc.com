<?php


namespace app\controllers\admin;


class MainController extends AdminAppController
{

    public function indexAction()
    {
        $countNewOrders = \R::count('orders', "status = '0'");
        $countUsers = \R::count('users');
        $countProducts = \R::count('products');
        $countCategories = \R::count('category');
        $this->setMeta('Админ панель');
        $this->set(compact('countNewOrders', 'countCategories', 'countProducts', 'countUsers'));
    }


}