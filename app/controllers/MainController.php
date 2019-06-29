<?php

namespace app\controllers;

use woodpc\Cache;

class MainController extends AppController
{
    public function indexAction()
    {
        $brands = \R::findAll('brands');
        $hits = \R::find('products',"hit = '1' AND status = '1' LIMIT 8");
        $this->setMeta('Главная страница');
        $this->set(compact('brands','hits'));
    }
}
