<?php


namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;
use yii\data\Sort;
use yii\web\HttpException;

class CategoryController extends AppController
{
    public function actionIndex(){
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta('Space-celebration');
        return $this->render('index',compact('hits'));
    }

    public function actionView($id){
        //$id = Yii::$app->request->get('id');

        $category = Category::findOne($id);
        if(empty($category))
            throw new HttpException(404, 'Такой категории нет');

        //$products = Product::find()->where(['category_id' => $id])->all();
        //$query = Product::find()->where(['category_id' => $id]);

        $sort = new Sort([
            'attributes' => [
                'price' => ['label' => 'Цена'],
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Наименование',
                ],
            ],
        ]);
        $query = Product::find()->where(['category_id' => $id])->orderBy($sort->orders);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 6, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $this->setMeta('Space-celebration | ' . $category->name, $category->keywords, $category->description);
        return $this->render('view', compact('products', 'pages', 'sort', 'category'));

    }

    public function actionSearch() {
        $q = trim(Yii::$app->request->get('q'));
        $this->setMeta('Space-celebration | ' . 'Поиск');
        if(!$q)
            return $this->render('search');
        $sort = new Sort([
            'attributes' => [
                'price' => ['label' => 'Цена'],
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Наименование',
                ],
            ],
        ]);

        $query = Product::find()->where(['like', 'name', $q])->orderBy($sort->orders);
        $totalCount = $query->count();
        $pages = new Pagination(['totalCount' => $totalCount, 'pageSize' => 6, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        //$this->setMeta('Space-celebration | ' . $category->name, $category->keywords, $category->description);
        return $this->render('search', compact('products', 'pages', 'sort', 'q','totalCount'));


    }

}