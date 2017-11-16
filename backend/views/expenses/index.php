<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ExpensesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Expenses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expenses-index">

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Search</h3>
        </div>
        <div class="box-body">

            <p>
                <?= Html::a('Create Expenses', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                      'attribute'=>'month',
                      'value'=>function($model){
                        $date = date_format(date_create($model->month),"F - Y");
                        return $date;
                      }
                    ],

                    [
                      'attribute'=>'total',
                      'value'=>function($model){
                        return '$'.number_format($model->total,2);
                      }
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {delete}'
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
