<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Item Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-list-index">

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
        <h3 class="box-title">Item List</h3>
      </div>
      <div class="box-body">
        <p>
            <?= Html::a('Create Item List', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
          //  'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'item',
                'item_name',
                'asset',
                'income',
                
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
      </div>
    </div>

</div>
