<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Order */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1>Просмотр заказа № <?= $model-> id;?> клиент <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'updated_at',
            'qty',
            'sum',
            //'status',
            [
                'attribute' => 'status',
                'value' => !$model->status ? '<span  class="text-danger">Активен</span>' : '<span  class="text-success">Завершен</span>',
                'format' => 'html',
            ],
            'name',
            'email:email',
            'phone',
            'address',
        ],
    ]) ?>

    <?php $items = $model->orderItems;?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>Наименование</th>
                <th class="text-center">Цена</th>
                <th class="text-center">Количество</th>
                <th class="text-center">Сумма</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><a href="<?= Url::to(['/product/view', 'id' => $item['product_id']]) ?>"><?= $item['name'] ?></a></td>
                    <td class="price text-center"><?= $item['price'] ?></td>
                    <td class="qty text-center"><?= $item['qty_item'] ?></td>
                    <td class="total text-center"><?= $item['sum_item'] ?></td>
                </tr>
            <?php endforeach; ?>
            <!--<tr>
                <td colspan="4">Итого: </td>
                <td class="text-center"><?/*= $session['cart.qty'] */?></td>
            </tr>
            <tr>
                <td colspan="4">На сумму: </td>
                <td class="text-center"><?/*= $session['cart.sum'] */?></td>
            </tr>-->
            </tbody>
        </table>
    </div>

</div>
