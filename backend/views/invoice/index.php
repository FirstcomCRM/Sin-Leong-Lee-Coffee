<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('Create Invoice', ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Truncate Invoice Tables', ['truncate'], ['class' => 'btn btn-danger']) ?>
            </p>


            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,

                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'month',
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
