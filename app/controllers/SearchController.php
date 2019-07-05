<?php

namespace app\controllers;

class SearchController extends AppController
{

    public function typeaheadAction()
    {
        if ($this->isAjax()) {
            $query = !empty(trim($_GET['query'])) ? trim($_GET['query']) : null;
            if ($query) {
                $products = \R::getAll('SELECT id, title FROM products WHERE title LIKE ? LIMIT 9', ["%{$query}%"]);
                echo json_encode($products);
            }
        }
        die;
    }

    public function indexAction()
    {
        $query = !empty(trim($_GET['s'])) ? trim($_GET['s']) : null;
        if ($query) {
            $products = \R::find('products', "title LIKE ? ", ["%{$query}%"]);
        }
        $this->setMeta('Поиск по :' . hsc($query));
        $this->set(compact('products','query'));
    }
}