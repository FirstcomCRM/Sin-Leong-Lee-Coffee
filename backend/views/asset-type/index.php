<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AssetTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asset Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-type-index">

      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="box box-info">
      <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
      </div>
      <div class="box-body">
        <p>
            <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
          //  'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

              //  'id',
                'asset',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
      </div>
    </div>




</div>
