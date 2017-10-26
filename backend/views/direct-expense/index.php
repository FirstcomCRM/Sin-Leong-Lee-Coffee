<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DirectExpenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Direct Expenses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="direct-expense-index">

    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Search</h3>
      </div>
      <div class="box-body">
          <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
      </div>
    </div>

    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">List</h3>
      </div>
      <div class="box-body">
        <p class="text-right">
            <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                      'attribute'=>'expense_type',
                      'value'=>function($model){
                        return Retrieve::retrieveAsset($model->expense_type);
                      }
                    ],
                    'customer_name',
                    'date',
                  
                    [
                      'attribute'=>'expenses',
                      'value'=>function($model){
                        return Retrieve::retrieveFormat($model->expenses);
                      },
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>
    </div>




</div>
