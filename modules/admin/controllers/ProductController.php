<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\UploadForm;
use Yii;
use app\modules\admin\models\Product;
use app\modules\admin\models\ProductPostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductPostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Товар {$model->name} добавлен");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->image){
                $model->upload();
            }
            unset($model->image);
            $model->gallery = UploadedFile::getInstances($model, 'gallery');
            $model->uploadGallery();
            Yii::$app->session->setFlash('success', "Товар {$model->name} изменен");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "Товар удален");
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpload(){
        $modelImport = new \yii\base\DynamicModel([
            'fileImport'=>'File Import',
        ]);
        $modelImport->addRule(['fileImport'],'required');
        $modelImport->addRule(['fileImport'],'file',['extensions'=>'ods,xls,xlsx'],['maxSize'=>1024*1024]);

        if(Yii::$app->request->post()){
            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport,'fileImport');
            if($modelImport->fileImport && $modelImport->validate()){
                $inputFileType = \PHPExcel_IOFactory::identify($modelImport->fileImport->tempName);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                /*$highestRow = $sheetData->getHighestRow();
                $highestColumn = $sheetData->getHighestColumn();*/

                $baseRow = 3;
                $count = 0;
                while(!empty($sheetData[$baseRow]['C'])){
                    $name = (string)$sheetData[$baseRow]['C'];
                    $id = (int)$sheetData[$baseRow]['A'];
                    $model = null;
                    if ($id){
                        $model = \app\models\Product::findOne($id);
                    }
                    if ($model == null){
                        $model = \app\models\Product::find()->where(['like', 'name', $name])->one();
                    }
                    if ($model == null) {
                        $model = new \app\models\Product();
                    }
                    $model-> name = $name;
                    $model-> category_id = (int)$sheetData[$baseRow]['B'];
                    $model-> content = (string)$sheetData[$baseRow]['D'];
                    $model-> price = (float)$sheetData[$baseRow]['E'];
                    $model-> keywords = (string)$sheetData[$baseRow]['F'];
                    $model->description = (string)$sheetData[$baseRow]['G'];
                    $model-> hit = (int)$sheetData[$baseRow]['H'];
                    $model-> sale = (int)$sheetData[$baseRow]['J'];
                    $model-> sale_percent = (int)$sheetData[$baseRow]['K'];
                    $model-> sort = (int)$sheetData[$baseRow]['L'];


                    $model->save();
                    $count++;
                    $baseRow++;
                }

                Yii::$app->getSession()->setFlash('success',"Товары успешно загружены в количестве $count");
            }else{
                Yii::$app->getSession()->setFlash('error','Error');
            }
        }

        return $this->render('upload',[
            'modelImport' => $modelImport,
        ]);
    }
}
