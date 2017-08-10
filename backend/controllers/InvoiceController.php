<?php

namespace backend\controllers;

use Yii;
use backend\models\Invoice;
use backend\models\InvoiceSearch;
use backend\models\InvoiceQuantity;
use backend\models\InvoicePerformance;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use backend\models\ImportExcel;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    public $invoice_id;
    public $invoice_name_id;
    public $item_code;
    public $grand_total = 0;
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
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model2 = new InvoiceSearch();
        $name = $model2->invoice_list($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'name' => $name,
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();


        if ($model->load(Yii::$app->request->post())) {
            $year =  Yii::$app->request->post('year');
            $month =  Yii::$app->request->post('month');
            $model->file = UploadedFile::getInstance($model,'file');


            if($model->file == null){

                Yii::$app->getSession()->setFlash('error', 'Select excel file');
                return $this->render('create', [
                    'model' => $model,
                ]);

            }else{

                $filename =  time().$model->file;
                $model->file->saveAs('uploads/invoice/'.$filename);
                $this->ImportExcel($filename,$year,$month);

            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function ImportExcel($filename,$year,$month){

        $inputFile = 'uploads/invoice/'.$filename;

        try{
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);
        } catch (Exception $e) {
            die('Error');
        }

        $invoice = new Invoice();
        $invoice->month = $month.' - '.$year;;
        if($invoice->save())
        {
                // than you can get id just like that
                
                $this->invoice_id = $invoice->id; // this is inserted item id

        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for($row=10; $row <= $highestRow; $row++)
        {
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);

            if($row==10)
            {
                continue;
            }

            $invoice_name = new InvoiceQuantity();
            $invoice_customer = new InvoicePerformance();
            
            
            if(!empty($rowData[0][1]) && !empty($rowData[0][2]) && empty($rowData[0][3]) && empty($rowData[0][4]) && empty($rowData[0][5]) && empty($rowData[0][6]) && empty($rowData[0][7]) && empty($rowData[0][8]) && empty($rowData[0][9]) && empty($rowData[0][10])){

                $invoice_name->item_code = (string)$rowData[0][1]; 
                $invoice_name->item_name = (string)$rowData[0][2];
                $invoice_name->invoice_id = $this->invoice_id; 
                $this->item_code = (string)$rowData[0][1];

                if($invoice_name->save())
                {
                        
                    $this->invoice_name_id = $invoice_name->id; // this is inserted item id

                }

                

            }else if((!empty($rowData[0][1]) && !empty($rowData[0][2]) && !empty($rowData[0][3])   && !empty($rowData[0][6]) && !empty($rowData[0][7]) && !empty($rowData[0][8]) && !empty($rowData[0][9]) && !empty($rowData[0][10])) || 


                (!empty($rowData[0][1]) && !empty($rowData[0][2]) && !empty($rowData[0][3])   && !empty($rowData[0][6]) && !empty($rowData[0][7]) && !empty($rowData[0][8]) && empty($rowData[0][9]) && !empty($rowData[0][10])))
            {


                $invoice_customer->customer_name  = (string)$rowData[0][1];
                $invoice_customer->invoice_no  = (string)$rowData[0][2]; 
                $date = (string)$rowData[0][3];
                $date_x = explode("/", $date);
                $yr = $date_x[2];
                $month = $date_x[1];
                $day = $date_x[0];
                $new_date =  $yr."-".$month."-".$day;
                $invoice_customer->date  = $new_date; 

                $invoice_customer->quantity  = (float)$rowData[0][4]; 
                $invoice_customer->amount  = (float)$rowData[0][5];
                preg_match('/([0-9]+\.[0-9]+)/', $rowData[0][7], $matches);
                
                $invoice_customer->average_cost  = (string)$matches[0];
                $invoice_customer->job_no  = (string)$rowData[0][8];
                $invoice_customer->sales_person  = (string)$rowData[0][9];
                $invoice_customer->customer_card_id = (string)$rowData[0][10];
                $invoice_customer->invoice_item_code = $this->item_code;
                $invoice_customer->invoice_id = $this->invoice_id;


                $invoice_customer->save();
                
            }else if (empty($rowData[0][1]) && empty($rowData[0][2]) && !empty($rowData[0][3]) && empty($rowData[0][6]) && empty($rowData[0][7]) && empty($rowData[0][8]) && empty($rowData[0][9]) && empty($rowData[0][10])) {
                
                $new_invoice_name = InvoiceQuantity::findOne($this->invoice_name_id);
                $new_invoice_name->total_quantity = (float)$rowData[0][4];
                $new_invoice_name->total_amount = (float)$rowData[0][5];
                $this->grand_total += (float)$rowData[0][5];
                $new_invoice_name->save();
            }else{
                continue;
            }

        }
        
        $new_invoice = Invoice::findOne($this->invoice_id);
        $new_invoice->total = $this->grand_total;
        
        if($new_invoice->save()){
            Yii::$app->getSession()->setFlash('success', 'Import Successfully');
            Yii::$app->response->redirect(['invoice/index']);
        }
        
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        InvoiceQuantity::deleteAll('invoice_id = '.$id);
        InvoicePerformance::deleteAll('invoice_id = '.$id);

        Yii::$app->getSession()->setFlash('success', 'Delete Successfully');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
