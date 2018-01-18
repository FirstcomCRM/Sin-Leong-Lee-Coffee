<?php

namespace backend\controllers;

use Yii;
use backend\models\CustomAsset;
use backend\models\CustomAssetSearch;
use backend\models\CustomAssetLine;
use backend\models\CustomAssetSum;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\Command;

/**
 * CustomerAssetController implements the CRUD actions for CustomAsset model.
 */
class CustomerAssetController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all CustomAsset models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomAssetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CustomAsset model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CustomAsset model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CustomAsset();
        $model_sum =new CustomAssetSum();
        $model_line = new CustomAssetLine();
        $model->purchase_date = date('Y-m-d');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveBoiler($model_sum,$model_line,$model);
            Yii::$app->session->setFlash('success', "Boiler Created!");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_sum'=>$model_sum,
                'model_line'=>$model_line,
            ]);
        }
    }

    /**
     * Updates an existing CustomAsset model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sum = CustomAssetSum::find()->where(['custom_asset_id'=>$id])->one();
        $model_line = CustomAssetLine::find()->where(['custom_asset_id'=>$id])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->db->createCommand()->delete('custom_asset_line', ['custom_asset_id' => $id])->execute();
            $this->saveBoiler($model_sum,$model_line,$model);
            Yii::$app->session->setFlash('success', "Boiler Updated!");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'model_sum'=>$model_sum,
                'model_line'=>$model_line,
            ]);
        }
    }

    /**
     * Deletes an existing CustomAsset model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function saveBoiler($model_sum,$model_line,$model){
        $model_sum->load(Yii::$app->request->post());
        $model_sum->custom_asset_id = $model->id;
        $model_sum->customer_name = $model->customer_name;
        $model_sum->purchase_date = $model->purchase_date;
        $model_sum->save(false);
        $years = Yii::$app->request->post('year_list');
        $dep_value = Yii::$app->request->post('dep_value');
        $dep_exp = Yii::$app->request->post('dep_expense');
        $counts = count($years);
        for ($i=0; $i < $counts ; $i++) {
             $model_line = new CustomAssetLine();
             $model_line->custom_asset_id = $model->id;
             $model_line->date_from = $years[$i];
             $model_line->dep_amount = $dep_value[$i];
             $model_line->dep_expense = $dep_exp[$i];
             $model_line->customer_name = $model->customer_name;
             $model_line->save(false);
        }
    }

    /**
     * Finds the CustomAsset model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomAsset the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomAsset::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
