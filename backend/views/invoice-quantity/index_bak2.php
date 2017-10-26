<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\InvoicePerformance;
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
      <?php echo '<pre>';
        //print_r($custFileDistinct);
        echo "</pre>";
      ?>
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php if (!empty($custFileDistinct)): ?>
          <?php foreach ($custFileDistinct as $key => $value): ?>
            <table class="table table-bordered">
              <thead>
                <th></th>
                <th><?php echo $value->customer_name ?></th>
                <th>Quantity</th>
              </thead>
              <tbody>
                <?php foreach ($custFileCode as $key_a => $value_a): ?>
                  <tr>
                    <td></td>
                    <td><?php echo $value_a->item_code. ' - '. $value_a->item_name ?></td>
                    <td>
                      <?php $total =  InvoicePerformance::find()->where(['item_code'=>$value_a->item_code, 'customer_name'=>$value->customer_name])->sum('quantity');
                      echo $total;
                      ?>
                    </td>
                  </tr>
                <?php endforeach; ?>

              </tbody>
            </table>
          <?php endforeach; ?>

        <?php endif; ?>


    </div>
  </div>
</div>
