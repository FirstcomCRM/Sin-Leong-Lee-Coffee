<?php

namespace backend\controllers;

use Yii;
use backend\models\InvoicePerformance;
use backend\models\InvoicePerformanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ChartsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new InvoicePerformanceSearch();
        $searchModel->perform_list(Yii::$app->request->queryParams);
        return $this->render('index',[
          'searchModel'=>$searchModel,
        ]);
    }

    public function actionQtyIndex(){
      $searchModel = new InvoicePerformanceSearch();
      $searchModel->perform_list(Yii::$app->request->queryParams);
      return $this->render('qty_index',[
        'searchModel'=>$searchModel,
      ]);
    }

}
