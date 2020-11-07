<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\CategoryPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            //'parent_id',
            [
              'attribute' => 'parent_id',
                'value' => function($data){
                    return $data->category->name ? $data->category->name : 'Нет';
                },
            ],
            'name',
            'keywords',
            'description',
            //'isActive',
            [
                'attribute' => 'isActive',
                'value' => function($data){
                    return !$data->isActive ? '<span  class="text-danger">Нет</span>' : '<span  class="text-success">Да</span>';
                },
                'format' => 'html',
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
