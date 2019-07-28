<?php
namespace app\controllers\admin;
use app\models\AppModel;
use woodpc\libs\Pagination;

class OrderController extends AdminAppController
{
    public function indexAction()
    {
        //Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 1;
        $count = \R::count('orders');
        $pagination = new Pagination($page,$perPage,$count);
        $start = $pagination->getStart();

        //переделай запрос
        $orders = \R::getAll("SELECT *,ROUND(SUM(price), 2) as amount  FROM orders as t1 
                                    JOIN users as t2 ON t1.user_id = t2.id
                                    JOIN order_product as t3 ON t1.id = t3.order_id
                                    GROUP BY t1.id ORDER BY t1.status, t1.id LIMIT $start,$perPage");

        $this->setMeta('Список заказов');
        $this->set(compact('orders','pagination','count'));
    }
}