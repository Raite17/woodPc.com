<?php


namespace app\controllers;

use app\models\Cart;
use app\models\Order;
use app\models\User;

class CartController extends AppController
{
    public function addAction()
    {
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
        $qty = !empty($_GET['qty']) ? (int)$_GET['qty'] : null;
        if ($id) {
            $product = \R::findOne('products', 'id = ?', [$id]);
            if (!$product) {
                return false;
            }
        }
        $cart = new Cart();
        $cart->addToCart($product, $qty);
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function showAction()
    {
        $this->loadView('cart_modal');
    }

    public function deleteAction()
    {
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
        if (isset($_SESSION['cart'][$id])) {
            $cart = new Cart();
            $cart->deleteCart($id);
        }
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function clearAction()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.amount']);
        unset($_SESSION['cart.currency']);
        $this->loadView('cart_modal');
    }

    public function viewAction()
    {
        $this->setMeta('Оформление заказа');
    }

    public function checkoutAction()
    {
        if (!empty($_POST)) {
            if (!User::checkAuth()) {
                $user = new User();
                $data = $_POST;
                $user->load($data);
                if (!$user->validate($data) || !$user->checkUnique()) {
                    $user->getErrors();
                    $_SESSION['form_data'] = $data;
                    redirect();
                } else {
                    $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                    if (!$user_id = $user->save('users')) {
                        $_SESSION['error'] = 'Ошибка!';
                        redirect();
                    }
                }
            }
            $data['user_id'] = isset($user_id) ? $user_id : $_SESSION['user']['id'];
            $data['note'] = !empty($_POST['note']) ? hsc($_POST['note']) : '';
            $user_email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : $_POST['email'];
            $order_id = Order::saveOrder($data);
            Order::finishOrder();
        }
        redirect();
    }
}