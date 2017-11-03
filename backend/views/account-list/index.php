<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Account Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-list-index">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Search</h3>
      </div>
      <div class="box-body">
          <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
      </div>
    </div>

    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Account List</h3>
      </div>
      <div class="box-body">
        <p class="text-right">
            <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Add', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
          //  'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

            //    'id',
                'account',
                'account_details',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
      </div>
    </div>

</div>
