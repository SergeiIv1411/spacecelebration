<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>


<!-- BREADCRUMB -->
<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?= \yii\helpers\Url::home()?>">Главная</a></li>
            <li class="active">Заказ</li>
        </ul>
    </div>
</div>
<!-- /BREADCRUMB -->

<hr class="container">
<?php if (Yii::$app->session->hasFlash('success') ): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span> </button>
        <?php echo Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('error') ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span> </button>
        <?php echo Yii::$app->session->getFlash('error'); ?>
    </div>
<?php endif; ?>
    <?php if(!empty($session['cart'])): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>Фото</th>
                    <th>Наименование</th>
                    <th class="text-center">Цена</th>
                    <th class="text-center">Количество</th>
                    <th class="text-center">Сумма</th>
                    <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($session['cart'] as $id => $item): ?>
                    <tr>
                        <td><?= \yii\helpers\Html::img($item['img'],['alt'=> $item['img'], 'height'=>50])  ?></td>
                        <td><a href="<?= Url::to(['product/view', 'id' => $id]) ?>"><?= $item['name'] ?></a></td>
                        <td class="price text-center"><?= $item['price'] ?></td>
                        <td class="qty text-center"><?= $item['qty'] ?></td>
                        <td class="total text-center"><?= $item['qty'] * $item['price'] ?></td>
                        <td><span data-id="<?= $id ?>" class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4">Итого: </td>
                    <td class="text-center"><?= $session['cart.qty'] ?></td>
                </tr>
                <tr>
                    <td colspan="4">На сумму: </td>
                    <td class="text-center"><?= $session['cart.sum'] ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        </hr>
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($order, 'name'); ?>
        <?= $form->field($order, 'email')->input('email'); ?>
        <?= $form->field($order, 'phone')->textInput(['placeholder'=>'(999) 999 9999'])
            ->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '+7(999) 999 99-99',
                'clientOptions' => [
                    'removeMaskOnSubmit' => true,
                ],
            ]) ?>
        <?= $form->field($order, 'address'); ?>
    <?= Html::submitButton('Заказать', ['class' => 'btn primary-btn']) ?>
        <?php $form = ActiveForm::end() ?>
    <?php else: ?>
        <h3>Корзина пуста</h3>
    <?php endif; ?>

</div>