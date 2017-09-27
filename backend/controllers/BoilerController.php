<?php

namespace backend\controllers;

use Yii;
use backend\models\Boiler;
use backend\models\BoilerSearch;
use backend\models\BoilerSum;
use backend\models\BoilerLine;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\InvoicePerformance;
use yii\helpers\ArrayHelper;
use yii\db\Command;

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
        $model_sum = BoilerSum::findOne($id);
        $model_line = BoilerLine::find()->where(['boiler_id'=>$id])->all();
    //    echo '<pre>';
    //    print_r($model_line);
    //    echo '</pre>';
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model_sum'=>$model_sum,
            'model_line'=>$model_line,
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
        $model_sum =new BoilerSum();


        if ($model->load(Yii::$app->request->post())  && $model->save() ) {

            $model_sum->load(Yii::$app->request->post());
            $model_sum->boiler_id = $model->id;
            $model_sum->save(false);
            $years = Yii::$app->request->post('year_list');
            $dep_value = Yii::$app->request->post('dep_value');
            $dep_exp = Yii::$app->request->post('dep_expense');
            $counts = count($years);
            for ($i=0; $i < $counts ; $i++) {
                 $model_line = new BoilerLine();
                 $model_line->boiler_id = $model->id;
                 $model_line->years = $years[$i];
                 $model_line->dep_amount = $dep_value[$i];
                 $model_line->dep_expense = $dep_exp[$i];
                 $model_line->save(false);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'customer' => $customer,
                'model_sum'=>$model_sum,
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
        $model_sum = BoilerSum::findOne($id);
        $model_line = BoilerLine::find()->where(['boiler_id'=>$id])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model_sum->load(Yii::$app->request->post());
            $model_sum->save(false);
            $years = Yii::$app->request->post('year_list');
            $dep_value = Yii::$app->request->post('dep_value');
            $dep_exp = Yii::$app->request->post('dep_expense');
            $counts = count($years);
            Yii::$app->db->createCommand()->delete('boiler_line', ['boiler_id' => $id])->execute();
            for ($i=0; $i < $counts ; $i++) {
                 $model_line = new BoilerLine();
                 $model_line->boiler_id = $model->id;
                 $model_line->years = $years[$i];
                 $model_line->dep_amount = $dep_value[$i];
                 $model_line->dep_expense = $dep_exp[$i];
                 $model_line->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'model_sum'=>$model_sum,
                'model_line'=>$model_line,
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

    public function actionTruncate(){
        Yii::$app->db->createCommand()->truncateTable('boiler')->execute();
        Yii::$app->db->createCommand()->truncateTable('boiler_line')->execute();
        Yii::$app->db->createCommand()->truncateTable('boiler_sum')->execute();
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
