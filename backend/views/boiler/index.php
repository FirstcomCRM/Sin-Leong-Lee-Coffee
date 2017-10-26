<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BoilerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Boilers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boiler-index">


    <div class="box box-warning">
      <div class="box-header with-border">
          <h3 class="box-title">Search</h3>
      </div>
      <div class="box-body">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
      </div>
    </div>

    <div class="box box-info">
      <div class="box-header with-border">
          <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
      </div>
      <div class="box-body">

        <p>
            <?= Html::a('Create Boiler', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Truncate Boiler Tables', ['truncate'], ['class' => 'btn btn-danger']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
        //    'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

              //  'id',
                'customer_name',
              /*  [
                  'attribute'=>'asset_type',
                  'value'=>function($model){
                    return Retrieve::retrieveAsset($model->asset_type);
                  },
                ],*/
                'purchase_date',
                [
                  'attribute'=>'amount',
                  'value'=>function($model){
                    return Retrieve::retrieveFormat($model->amount);
                  },
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
      </div>
    </div>



</div>
