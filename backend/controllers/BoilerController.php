<?php

namespace backend\controllers;

use Yii;
use backend\models\Boiler;
use backend\models\BoilerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\InvoicePerformance;
use yii\helpers\ArrayHelper;

/**
 * BoilerController implements the CRUD actions for Boiler model.
 */
class BoilerController extends Controller
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
     * Lists all Boiler models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BoilerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Boiler model.
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
     * Creates a new Boiler model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $customer = ArrayHelper::map(InvoicePerformance::find()->select('customer_name')->orderBy(['customer_name'=>SORT_ASC])->distinct()->all(), 'customer_name', 'customer_name');
        $model = new Boiler();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //    print_r($model->year);die();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'customer' => $customer,
            ]);
        }
    }

    /**
     * Updates an existing Boiler model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $customer = ArrayHelper::map(InvoicePerformance::find()->select('customer_name')->orderBy(['customer_name'=>SORT_ASC])->distinct()->all(), 'customer_name', 'customer_name');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'customer'=>$customer,
            ]);
        }
    }

    /**
     * Deletes an existing Boiler model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Boiler model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Boiler the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Boiler::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
