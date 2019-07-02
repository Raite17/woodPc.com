<?php


namespace app\models;


use woodpc\App;

class Breadcrumbs
{
    public static function getBreadCrumbs($category_id, $name = '')
    {
        $categories = App::$app->getProperty('categories');
        $breadCrumbsArray = self::getParts($categories, $category_id);
        $breadCrumbs = "<li><a href='" . PATH . "'>Главная</a></li>";
        if ($breadCrumbsArray) {
            foreach ($breadCrumbsArray as $alias => $title) {
                $breadCrumbs .= "<li><a href='" . PATH . "/category/{$alias}'>{$title}</a></li>";
            }
        }
        if ($name) {
            $breadCrumbs .= "<li>$name</li>";
        }
        return $breadCrumbs;
    }

    public static function getParts($categories, $id)
    {
        if (!$id) return false;
        $breadCrumbs = [];
        foreach ($categories as $key => $value) {
            if (isset($categories[$id])) {
                $breadCrumbs[$categories[$id]['alias']] = $categories[$id]['title'];
                $id = $categories[$id]['parent_id'];
            } else break;
        }
        return array_reverse($breadCrumbs, true);
    }
}