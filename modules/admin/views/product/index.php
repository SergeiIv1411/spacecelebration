<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ProductPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'category_id',
            [
                'attribute' => 'category_id',
                'value' => function($data){
                    return $data->category->name ? $data->category->name : 'Нет';
                },
            ],
            'name',
            //'content:ntext',
            'price',
            //'keywords',
            //'description',
            //'img',
            //'hit',
            [
                'attribute' => 'hit',
                'value' => function($data){
                    return !$data->hit ? '<span  class="text-danger">Нет</span>' : '<span  class="text-success">Да</span>';
                },
                'format' => 'html',
            ],
            //'new',
            [
                'attribute' => 'new',
                'value' => function($data){
                    return !$data->new ? '<span  class="text-danger">Нет</span>' : '<span  class="text-success">Да</span>';
                },
                'format' => 'html',
            ],
            //'sale',
            [
                'attribute' => 'sale',
                'value' => function($data){
                    return !$data->sale ? '<span  class="text-danger">Нет</span>' : '<span  class="text-success">Да</span>';
                },
                'format' => 'html',
            ],
            //'sale_percent',
            //'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
