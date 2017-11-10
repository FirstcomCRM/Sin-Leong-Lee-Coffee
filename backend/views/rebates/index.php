<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RebatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rebates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rebates-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Rebates and Discount Files</h3>
      </div>
      <div class="box-body">
        <p>
            <?= Html::a('<i class="fa fa-arrow-up" aria-hidden="true"></i> Import', ['create'], ['class' => 'btn btn-success']) ?>
            <?php Html::a('<i class="fa fa-arrow-up" aria-hidden="true"></i> Truncate', ['truncate'], ['class' => 'btn btn-danger']) ?>

        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
        //    'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

            //    'id',
                'date_uploaded',
              //  'total',

              ['class' => 'yii\grid\ActionColumn',
                  'template' => '{view} {delete}'
              ],
            ],
        ]); ?>
      </div>
    </div>


</div>
