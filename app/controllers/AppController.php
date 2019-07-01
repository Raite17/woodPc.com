<?php

namespace app\controllers;

use app\models\AppModel;
use app\widgets\currency\Currency;
use woodpc\App;
use woodpc\base\Controller;
use woodpc\Cache;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        $setCurrenciesRegisty = App::$app->setProperty('currencies', Currency::getCurrencies());
        $getPropertyCurrencies = App::$app->getProperty('currencies');
        $setPropertyCurrencies = App::$app->setProperty('currency', Currency::getCurrency($getPropertyCurrencies));
        App::$app->setProperty('categories', self::cacheCategory());
    }

    public static function cacheCategory()
    {
        $cache = Cache::instance();
        $categories = $cache->get('categories');
        if(!$categories) {
            $categories = \R::getAssoc("SELECT * FROM category");
            $cache->set('categories',$categories);
        }
        return $categories;
    }
}