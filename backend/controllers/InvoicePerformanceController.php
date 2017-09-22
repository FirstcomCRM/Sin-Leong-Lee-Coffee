<?php

namespace backend\controllers;

use Yii;
use mPDF;
use backend\models\InvoicePerformance;
use backend\models\InvoicePerformanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * InvoicePerformanceController implements the CRUD actions for InvoicePerformance model.
 */
class InvoicePerformanceController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        if(Yii::$app->user->isGuest){

            return [

                ' access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['login', 'error'],
                            'allow' => true,
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];

        }else{

            return [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }
    }

    /**
     * Lists all InvoicePerformance models.
     * @return mixed
     */
    public function actionIndex()
    {


        $model = new InvoicePerformanceSearch();
        ini_set('max_execution_time', 180);
        ini_set("memory_limit", "512M");

        if(Yii::$app->request->post('search')){
            $year = Yii::$app->request->post('year');
            $month =  Yii::$app->request->post('month');
            $list = $model->performance_list($month,$year);

            return $this->render('index', [
                'list'=>$list,
            ]);

        }else if(Yii::$app->request->post('excel')){

            $year = Yii::$app->request->post('year');
            $month =  Yii::$app->request->post('month');
            $this->actionExcel($year,$month);
            //return $this->redirect(['user/index']);


        }else if(Yii::$app->request->post('pdf')){

            $year = Yii::$app->request->post('year');
            $month =  Yii::$app->request->post('month');
            $this->actionPdf($year,$month);


        }else{

            $list = $model->performance_list();
            $list = null;
            return $this->render('index', [
                'list' => $list,
            ]);


        }
    }
    public function actionExcel($year,$month){

        $model = new InvoicePerformanceSearch();
        $data['year'] = $year;
        $data['month'] = $month;
        $data['list'] = $model->performance_list($month,$year);

        if(count($data['list']) == 0){
            Yii::$app->getSession()->setFlash('error', 'Data is empty');
            return $this->redirect(['invoice-quantity/index']);
        }else{

            return $this->render('excel', $data);
        }

    }
    public function actionPdf($year,$month){

        $model = new InvoicePerformanceSearch();
        $data['year'] = $year;
        $data['month'] = $month;
        $data['list'] = $model->performance_list($month,$year);
        if(count($data['list']) == 0){
            Yii::$app->getSession()->setFlash('error', 'Data is empty');
            return $this->redirect(['invoice-quantity/index']);
        }else{

            $mpdf = new mPDF;
            $data['mpdf'] = $mpdf;
            $pdf = $this->render('pdf', $data);
        }


    }


    protected function findModel($id)
    {
        if (($model = InvoicePerformance::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
