<?php


namespace app\widgets\menu;


use woodpc\App;
use woodpc\Cache;

class Menu
{
    //Свойство для данных
    protected $data;
    //Массив дерева который строится из $data
    protected $tree;
    //Готовый HTMl код для меню
    protected $menuHtml;
    //Шаблон для меню
    protected $tpl;
    //Контейнер для меню
    protected $container = 'ul';
    //Класс для контейнера
    protected $class = 'menu';
    //Таблица в бд из которой выбираем данные
    protected $table = 'category';
    //Кэш по умолчанию - 1 час.
    protected $cache = 3600;
    //Ключ под котором сохраняются данные в файл 'tmp/cache/.txt'
    protected $cacheKey = 'woodPc_menu';
    protected $prepend = '';

    public function __construct($options = [])
    {
        $this->tpl = __DIR__ . '/menu_tpl/menu.php';
        $this->getOptions($options);
        $this->run();
    }

    protected function getOptions($options)
    {
        foreach ($options as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    protected function run()
    {
        $cache = Cache::instance();
        $this->menuHtml = $cache->get($this->cacheKey);
        if (!$this->menuHtml) {
            $this->data = App::$app->getProperty('categories');
            if (!$this->data) {
                $this->data = $cats = \R::getAssoc("SELECT * FROM {$this->table}");
            }
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
            if ($this->cache) {
                $cache->set($this->cacheKey, $this->menuHtml, $this->cache);
            }
        }
        $this->output();
    }

    protected function output()
    {
        $attrs = '';
        if (!empty($this->attrs)) {
            foreach ($this->attrs as $key => $value) {
                $attrs .= "$key='$value'";
            }
        }
        echo "<{$this->container} class='{$this->class}' $attrs>";
            echo $this->prepend;
            echo $this->menuHtml;
        echo "</{$this->container}>";
    }

    protected function getTree()
    {
        $tree = [];
        $data = $this->data;
        foreach ($data as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $data[$node['parent_id']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = '')
    {
        $str = '';
        foreach ($tree as $id => $category) {
            $str .= $this->categoryToTpl($category, $tab, $id);
        }
        return $str;
    }

    protected function categoryToTpl($category, $tab, $id)
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }
}