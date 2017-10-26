<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\InvoicePerformance;
//use yii\widgets\LinkPager;
//use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoiceQuantitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$number = 1;
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
        <div class="table table-responsive">
          <?php if (!empty($custFileDistinct)): ?>
            <?php foreach ($custFileDistinct as $key => $value): ?>
              <table class="table table-bordered">
                <thead>
                     <th></th>
                     <th><?php echo $value->customer_name ?></th>
                     <th>Quantity</th>
                </thead>
                <tbody>
                  <?php $file = InvoicePerformance::find()->select(['item_name','item_code'])->distinct()
                    ->andFilterWhere(['between','date',$date_from,$date_to])
                    ->andFilterWhere(['like', 'customer_name', $searchModel->customer_name])
                    ->andFilterWhere(['like', 'item_code',$searchModel->item_code])
                    ->andFilterWhere(['like', 'item_name',$searchModel->item_name])
                    ->all();
                   ?>
                  <?php foreach ($file as $key_a => $value_a): ?>
                    <?php $total =  InvoicePerformance::find()->where(['item_code'=>$value_a->item_code,'item_name'=>$value_a->item_name, 'customer_name'=>$value->customer_name])
                                    ->andFilterWhere(['between','date',$date_from,$date_to])
                                    ->sum('quantity'); ?>


                    <?php if (!empty($total)): ?>
                    <tr>
                          <td class="qty-num"><?php echo $number ?></td>
                          <td class="qty-main"><?php echo $value_a->item_code. ' - '. $value_a->item_name ?></td>
                          <td class="qty-main">
                             <?php echo $total ?>
                          </td>
                          <?php $number += 1 ?>
                    </tr>
                      <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>

              </table>
              <br>
              <?php $number = 1 ?>
            <?php endforeach; ?>



          <?php endif; ?>
        </div>



    </div>
  </div>
</div>
