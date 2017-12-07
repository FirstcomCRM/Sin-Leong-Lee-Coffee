<?php

namespace backend\controllers;

use Yii;
use mPDF;
use backend\models\InvoiceQuantity;
use backend\models\InvoiceQuantitySearch;
use backend\models\InvoicePerformance;
use backend\models\InvoicePerformanceSearch;
use backend\models\ItemList;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
/**
 * InvoiceQuantityController implements the CRUD actions for InvoiceQuantity model.
 */
class InvoiceQuantityController extends Controller
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
     * Lists all InvoiceQuantity models.
     * Generate a report based on the filters. Show the records if user press the search button.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new InvoicePerformanceSearch();
        ini_set('max_execution_time', 300);
        ini_set("memory_limit", "512M");

        $custFileDistinct =$searchModel->quantity_list((Yii::$app->request->queryParams));
        $ym_from = $searchModel->month_from.'-'.$searchModel->year_from;
        $ym_to = $searchModel->month_to.'-'.$searchModel->year_to;
        $date_from = date('Y-m-01', strtotime($ym_from));
        $date_to = date('Y-m-t', strtotime($ym_to));

        return $this->render('index', [
            'searchModel'=> $searchModel,
            'custFileDistinct'=>$custFileDistinct,
            'date_from'=>$date_from,
            'date_to'=>$date_to,

        ]);

    }
    public function actionExcel($year,$month){

        $model = new InvoiceQuantitySearch();
        $data['year'] = $year;
        $data['month'] = $month;
        $data['list'] = $model->quantity_list($month,$year);

        if(count($data['list']) == 0){
            Yii::$app->getSession()->setFlash('error', 'Data is empty');
            return $this->redirect(['invoice-quantity/index']);
        }else{

            return $this->render('excel', $data);
        }

    }
    public function actionPdf($year,$month){

        $model = new InvoiceQuantitySearch();
        $data['year'] = $year;
        $data['month'] = $month;
        $data['list'] = $model->quantity_list($month,$year);
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
        if (($model = InvoiceQuantity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
