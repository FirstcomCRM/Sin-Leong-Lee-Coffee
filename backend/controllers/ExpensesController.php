<?php

namespace backend\controllers;

use Yii;
use backend\models\Expenses;
use backend\models\ExpensesSearch;
use backend\models\ExpensesReport;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use backend\models\ImportExcel;

/**
 * ExpensesController implements the CRUD actions for Expenses model.
 */
class ExpensesController extends Controller
{
    public $expenses_id;
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
     * Lists all Expenses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExpensesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Expenses model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $list = ExpensesReport::find()->where(['expenses_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'list' => $list,
        ]);
    }

    /**
     * Creates a new Expenses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Expenses();

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
                $model->file->saveAs('uploads/expenses/'.$filename);
                $this->ImportExcel($filename,$year,$month);

            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function ImportExcel($filename,$year,$month){

        $inputFile = 'uploads/expenses/'.$filename;

        try{
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);
        } catch (Exception $e) {
            die('Error');
        }

        $expenses = new Expenses();
        $expenses->month = $year.'-'.$month.'-01';
        if($expenses->save())
        {
                // than you can get id just like that
                
                $this->expenses_id = $expenses->id; // this is inserted item id

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

            $expenses_report = new ExpensesReport();
            $expenses_report->id_no = (string)$rowData[0][1]; 
            $expenses_report->scr = (string)$rowData[0][2];
            $expenses_report->date = (string)$rowData[0][3]; 
            $expenses_report->memo = (string)$rowData[0][4];
            $expenses_report->debit = (string)$rowData[0][5]; 
            $expenses_report->credit = (string)$rowData[0][6];
            $expenses_report->job_no = (string)$rowData[0][7]; 
            $expenses_report->net_activity = (string)$rowData[0][8];
            $expenses_report->ending_balance = (string)$rowData[0][9];
            $expenses_report->expenses_id = $this->expenses_id; 
            $expenses_report->save();
            
            if($rowData[0][4] == 'Grand Total:'){
                //echo 'hello';
                $this->grand_total = $rowData[0][5];
                $expenses_new = Expenses::findOne($this->expenses_id);
                $expenses_new->total = $this->grand_total;
                
                if($expenses_new->save()){
                    Yii::$app->getSession()->setFlash('success', 'Import Successfully');
                    Yii::$app->response->redirect(['expenses/index']);
                }
                break;
                
            }else{
                continue;
            }

        }
        
        
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        ExpensesReport::deleteAll('expenses_id = '.$id);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Expenses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Expenses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Expenses::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
