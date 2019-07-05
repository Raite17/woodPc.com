<?php


namespace app\models;
use woodpc\App;

class Category extends AppModel
{
    public function getIds($id)
    {
        $categories = App::$app->getProperty('categories');
        $ids = null;
        foreach ($categories as $key => $value) {
            if ($value['parent_id'] == $id) {
                $ids .= $key . ',';
                $ids .= $this->getIds($key);
            }
        }
        return $ids;
    }
}