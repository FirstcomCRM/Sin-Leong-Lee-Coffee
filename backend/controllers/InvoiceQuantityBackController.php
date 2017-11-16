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
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new InvoicePerformanceSearch();
        $custFile='';
        $custFileDistinct = '';
        $custFileCode = '';
        $date_from = '';
        $date_to = '';
        ini_set('max_execution_time', 300);
        ini_set("memory_limit", "512M");
  

     if (Yii::$app->request->post()) {
        $dataProvider = $searchModel->quantity_list(Yii::$app->request->post());

        $ym_from = $searchModel->month_from.'-'.$searchModel->year_from;
        $ym_to = $searchModel->month_to.'-'.$searchModel->year_to;
        $date_from = date('Y-m-01', strtotime($ym_from));
        $date_to = date('Y-m-t', strtotime($ym_to));
    //    $custFileCode = InvoicePerformance::find()->select(['customer_name', 'item_name','item_code'])->distinct()->orderBy(['customer_name'=>SORT_ASC])
    //            ->andFilterWhere(['between','date',$date_from,$date_to])
    //            ->andFilterWhere(['like', 'customer_name', $searchModel->customer_name])
      //          ->andFilterWhere(['like', 'item_code',$searchModel->item_code])
    //            ->andFilterWhere(['like', 'item_name',$searchModel->item_name])
    //            ->all();
    /*    $query =  InvoicePerformance::find()->select(['customer_name'])->distinct()
                      ->andFilterWhere(['between','date',$date_from,$date_to])
                      ->andFilterWhere(['like', 'customer_name', $searchModel->customer_name])
                     ->andFilterWhere(['like', 'item_code',$searchModel->item_code])
                     ->andFilterWhere(['like', 'item_name',$searchModel->item_name]);

                     $pagination = new Pagination([
                       'defaultPageSize'=>20,
                       'totalCount'=> $query->count(),
                     ]);*/
                //     print_r($pagination);die();

        $custFileDistinct = InvoicePerformance::find()->select(['customer_name'])->distinct()
                      ->andFilterWhere(['between','date',$date_from,$date_to])
                      ->andFilterWhere(['like', 'customer_name', $searchModel->customer_name])
                     ->andFilterWhere(['like', 'item_code',$searchModel->item_code])
                     ->andFilterWhere(['like', 'item_name',$searchModel->item_name])
                  //    ->offset($pagination->offset)
                  //    ->limit($pagination->limit)
                     ->all();




            //         die();
        return $this->render('index', [
            //'dataProvider'=>$dataProvider,
            'searchModel'=> $searchModel,
      //      'custFileCode'=>$custFileCode,
            'custFileDistinct'=>$custFileDistinct,
        //     'pagination' => $pagination,
            'date_from'=>$date_from,
            'date_to'=>$date_to
        ]);
      }else{

        $searchModel->id = 0;
        $dataProvider = $searchModel->quantity_list(Yii::$app->request->post());
        return $this->render('index', [
            //'dataProvider'=>$dataProvider,
            'searchModel'=> $searchModel,
            'custFileDistinct'=>$custFileDistinct,
            'custFileCode'=>  $custFileCode
        ]);
     }


/*        $model = new InvoiceQuantitySearch();


        if(Yii::$app->request->post('search')){
            $year = Yii::$app->request->post('year');
            $month =  Yii::$app->request->post('month');
            //die();
            $list = $model->quantity_list($month,$year);

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


            $list = $model->quantity_list();
            $list = null;
            return $this->render('index', [
                'list'=>$list,
            ]);
        }*/


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
