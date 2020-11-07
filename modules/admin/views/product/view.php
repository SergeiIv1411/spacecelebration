<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот товар?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php $img = $model->getImage();?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'category_id',
            [
                'attribute' => 'parent_id',
                'value' => $model->category->name ? $model->category->name : 'Нет',
            ],
            'name',
            'content:html',
            'price',
            'keywords',
            'description',
            [
                    'attribute' => 'image',
                    'value' => "<img src='{$img->getUrl()}'>",
                    'format' => 'html',
            ],
            //'hit',
            [
                'attribute' => 'hit',
                'value' => $model->hit ? '<span  class="text-success">Да</span>' : '<span  class="text-danger">Нет</span>',
                'format' => 'html',
            ],
            //'new',
            [
                'attribute' => 'new',
                'value' => $model->new ? '<span  class="text-success">Да</span>' : '<span  class="text-danger">Нет</span>',
                'format' => 'html',
            ],
            //'sale',
            [
                'attribute' => 'sale',
                'value' => $model->sale ? '<span  class="text-success">Да</span>' : '<span  class="text-danger">Нет</span>',
                'format' => 'html',
            ],
            'sale_percent',
            'sort',
        ],
    ]) ?>

</div>
