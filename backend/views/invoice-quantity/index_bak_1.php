<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoiceQuantitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice Quantity';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.select2-selection__rendered{
  line-height: 200%;
}

</style>


<div class="invoice-quantity-index">
  <div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

      <?= GridView::widget([
          'dataProvider' => $dataProvider,
      //    'filterModel' => $searchModel,
          'columns' => [
              ['class' => 'yii\grid\SerialColumn'],

            //  'id',
              'customer_name',
              'date',
              'quantity',
              'amount',
            //  'job_no',
          //    'item_code',
            //  'item_name',
          //    'item_abbr',
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
