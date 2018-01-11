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
use backend\models\RebateReport;
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
        ini_set('max_execution_time', 180);
        ini_set("memory_limit", "512M");

        $searchModel = new InvoicePerformanceSearch();
        $date_to = '';
        $date_from='';

        if (Yii::$app->request->post()) {
          //$searchModel->perform_list(Yii::$app->request->post());
          $valid =  $searchModel->perform_list(Yii::$app->request->post());
          $test = $valid->getModels();

          if (empty($test)) {
              Yii::$app->getSession()->setFlash('error', 'No records found');
              return $this->render('index', [
                  'searchModel'=> $searchModel,
                  'date_to'=>$date_to,
                  'date_from'=>$date_from
              ]);
          }else{
            $ym_from = $searchModel->month_from.'-'.$searchModel->year_from;
            $ym_to = $searchModel->month_to.'-'.$searchModel->year_to;
            $date_from = date('Y-m-01', strtotime($ym_from));
            $date_to = date('Y-m-t', strtotime($ym_to));

            $this->layout='reports.php';
            return $this->render('report', [
                'searchModel'=> $searchModel,
                'date_to'=>$date_to,
                'date_from'=>$date_from
            ]);
          }

        }else{
          return $this->render('index', [
              'searchModel'=> $searchModel,
              'date_to'=>$date_to,
              'date_from'=>$date_from
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
