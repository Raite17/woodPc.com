<?php

namespace app\controllers;

use app\models\AppModel;
use app\widgets\currency\Currency;
use woodpc\App;
use woodpc\base\Controller;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        $setCurrenciesRegisty = App::$app->setProperty('currencies', Currency::getCurrencies());
        $getPropertyCurrencies = App::$app->getProperty('currencies');
        $setPropertyCurrencies = App::$app->setProperty('currency', Currency::getCurrency($getPropertyCurrencies));
    }
}