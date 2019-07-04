<?php


namespace app\models;


use woodpc\App;

class Cart extends AppModel
{
    public function addToCart($product, $qty = 1)
    {
        if (!isset($_SESSION['cart.currency'])) {
            $_SESSION['cart.currency'] = App::$app->getProperty('currency');
        }
        $id = $product->id;
        $title = $product->title;
        $price = $product->price;
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$id] = [
                'title' => $title,
                'price' => $price * $_SESSION['cart.currency']['value'],
                'alias' => $product->alias,
                'qty' => $qty,
                'img' => $product->img,
            ];
        }
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
        $_SESSION['cart.amount'] = isset($_SESSION['cart.amount']) ? $_SESSION['cart.amount']
            + $qty * ($price * $_SESSION['cart.currency']['value']) : $qty * ($price * $_SESSION['cart.currency']['value']);
    }

    public function deleteCart($id)
    {
        $qtyMinus = $_SESSION['cart'][$id]['qty'];
        $amountMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
        $_SESSION['cart.qty'] -= $qtyMinus;
        $_SESSION['cart.amount'] -= $amountMinus;
        unset($_SESSION['cart'][$id]);
    }

    public static function recount($currency)
    {
        if (isset($_SESSION['cart.currency'])) {
            if ($_SESSION['cart.currency']['base']) {
                $_SESSION['cart.amount'] *= $currency->value;
            } else {
                $_SESSION['cart.amount'] = $_SESSION['cart.amount'] / $_SESSION['cart.currency']['value'] * $currency->value;
            }
            foreach ($_SESSION['cart'] as $key => $value) {
                if (($_SESSION['cart.currency']['base'])) {
                    $_SESSION['cart'][$key]['price'] *= $currency->value;
                } else {
                    $_SESSION['cart'][$key]['price'] = $_SESSION['cart'][$key]['price'] /
                        $_SESSION['cart.currency']['value'] * $currency->value;
                }
            }
            foreach ($currency as $key => $value) {
                $_SESSION['cart.currency'][$key] = $value;
            }
        }
    }
}