<?php


namespace app\controllers;
use app\models\Product;
use app\models\Cart;
use app\models\Order;
use app\models\OrderItems;
use Yii;

class CartController extends AppController
{
    /*public function actionAdd(){
        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);
        if(empty($product)) return false;
        $session = YII::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->addToCart($product);
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }*/

    public function actionAdd(){
        $id  = Yii::$app->request->get('id');
        $qty = (int)Yii::$app->request->get('qty');
        $qty = !$qty ? 1 : $qty;
        $product = Product::findOne($id);
        if(empty($product)) return false;
        $session = YII::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->addToCart($product, $qty);
        $arr = array('qty' => $session['cart.qty'], 'sum' => $session['cart.sum']);
        return json_encode($arr);
    }

    public function actionClear() {
        $session = YII::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionDelItem() {
        $id = Yii::$app->request->get('id');
        $session = YII::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->recalc($id);
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionShow() {
        $session = YII::$app->session;
        $session->open();
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionView() {
        $session = YII::$app->session;
        $session->open();
        $this->setMeta('Корзина');
        $order = new Order();
        if ($order->load(Yii::$app->request->post())) {
            $order->qty = $session['cart.qty'];
            $order->sum = $session['cart.sum'];
            if($order->save()){
                $this->saveOrderItems($session['cart'], $order->id);
                Yii::$app->session->setFlash('success', 'Ваш заказ принят. Менеджер вскоре свяжется с вами');
                Yii::$app->mailer->compose('order', ['session' => $session])
                    ->setFrom(['space_celebration@mail.ru' => 'space-celebration'])
                    ->setTo($order->email)
                    ->setSubject('Заказ')
                    ->send();
                /*$admin_mail = Yii::$app->params['adminEmail'];
                Yii::$app->mailer->compose('order', ['session' => $session])
                    ->setFrom(['space_celebration@mail.ru' => 'space-celebration'])
                    ->setTo($admin_mail)
                    ->setSubject('Заказ с сайта')
                    ->send();*/
                $session->remove('cart');
                $session->remove('cart.qty');
                $session->remove('cart.sum');
                return $this->refresh();
            }else{
                Yii::$app->session->setFlash('error', 'Ошибка оформления заказа');
            }
        }
        return $this->render('view', compact('session', 'order'));
    }

    protected function saveOrderItems($items, $order_id){
        $data = array();
        foreach ($items as $id => $item){
            $data[] = [$order_id, $id, $item['name'], $item['price'], $item['qty'], $item['qty'] * $item['price']];
            /*$order_items = new OrderItems();
            $order_items->order_id = $order_id;
            $order_items->product_id = $id;
            $order_items->name = $item['name'];
            $order_items->price = $item['price'];
            $order_items->qty_item = $item['qty'];
            $order_items->sum_item = $item['qty'] * $item['price'];
            $order_items->save();*/
        }
        Yii::$app->db
            ->createCommand()
            ->batchInsert('order_items', ['order_id', 'product_id', 'name', 'price', 'qty_item', 'sum_item'],$data)
            ->execute();
    }

}