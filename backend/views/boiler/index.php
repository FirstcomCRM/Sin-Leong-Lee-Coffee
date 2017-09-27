<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BoilerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Boilers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boiler-index">


    <div class="box box-info">
      <div class="box-header with-border">
          <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
      </div>
      <div class="box-body">
          <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
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
                'customer',
                'bolter_no',
                'invoice_no',
                'pur_date',
                // 'pur_cost',
                // 'cost',
                // 'acc_depn',
                // 'year',
                // 'depn',
                // 'nbv',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
      </div>
    </div>



</div>
