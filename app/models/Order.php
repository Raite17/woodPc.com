<?php


namespace app\models;


use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use woodpc\App;

class Order extends AppModel
{
    public static function saveOrder($data)
    {
        $order = \R::dispense('orders');
        $order->user_id = $data['user_id'];
        $order->note = $data['note'];
        $order->currency = $_SESSION['cart.currency']['code'];
        $order_id = \R::store($order);
        self::saveOrderProduct($order_id);
        return $order_id;
    }

    public static function saveOrderProduct($order_id)
    {
        $sql = '';
        foreach ($_SESSION['cart'] as $product_id => $product) {
            $product_id = (int)$product_id;
            $sql .= "($order_id,$product_id,{$product['qty']},'{$product['title']}',{$product['price']}),";
        }
        $sql = rtrim($sql, ',');
        \R::exec("INSERT INTO order_product (order_id,product_id,qty,title,price) VALUES $sql");
    }

    public static function finishOrder()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.amount']);
        unset($_SESSION['cart.currency']);
        $_SESSION['success'] = 'Спасибо за ваш заказ.В ближайшее время с вами свяжется менеджер для согласования заказа';
    }
}