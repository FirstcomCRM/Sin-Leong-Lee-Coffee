<?php

namespace backend\controllers;

use Yii;
use mPDF;
use backend\models\InvoicePerformance;
use backend\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerController implements the CRUD actions for InvoicePerformance model.
 */
class CustomerController extends Controller
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
     * Lists all InvoicePerformance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new CustomerSearch();
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->request->post('search')){
            $customer = Yii::$app->request->post('customer');
            $month_from = Yii::$app->request->post('month_from');
            $month_to = Yii::$app->request->post('month_to');
            $year_from = Yii::$app->request->post('year_from');
            $year_to =Yii::$app->request->post('year_to');

            $list_all = $model->customer_list_all($customer,$month_from,$month_to,$year_from,$year_to);
          //  $list = $model->customer_list_all();
            $list = $model->customer_list_daterange($month_from,$month_to,$year_from,$year_to);
             /*echo '<pre>';

            print_r($list_all);
            echo '</pre>';
            die();*/

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'list' => $list,
                'list_all' => $list_all,
            ]);



        }else if(Yii::$app->request->post('pdf')){

            $customer = Yii::$app->request->post('customer');
            $month_from = Yii::$app->request->post('month_from');
            $month_to = Yii::$app->request->post('month_to');
            $year_from = Yii::$app->request->post('year_from');
            $year_to =Yii::$app->request->post('year_to');
            $this->actionPdf($customer,$month_from,$month_to,$year_from,$year_to);

        }else{


            $list = $model->customer_list_all();

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'list' => $list,
            ]);
        }

    }
    public function actionPdf($customer,$month_from,$month_to,$year_from,$year_to){

        $model = new CustomerSearch();

        $data['list_all'] = $model->customer_list_all($customer,$month_from,$month_to,$year_from,$year_to);
        if(count($data['list_all']) == 0){
            Yii::$app->getSession()->setFlash('error', 'Data is empty');
            return $this->redirect(['customer/index']);
        }else{

            $mpdf = new mPDF;
            $data['mpdf'] = $mpdf;
            $pdf = $this->render('pdf', $data);
        }


    }

    /**
     * Displays a single InvoicePerformance model.
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
     * Creates a new InvoicePerformance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InvoicePerformance();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InvoicePerformance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InvoicePerformance model.
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
     * Finds the InvoicePerformance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InvoicePerformance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InvoicePerformance::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
