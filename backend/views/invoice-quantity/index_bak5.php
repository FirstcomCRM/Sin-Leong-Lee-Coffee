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
$letter = 'a';
$a = 1;
$date_contain = [];
$date_compare = null;

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
           <h6>Origin Date Start:</h6> <?php echo $date_from ?>
           <h6>Origin Date End</h6><?php echo $date_to ?>
           <h6>Origin Date End modified to 1</h6>
           <?php
              $date_b = date('Y-m-01',strtotime($date_to));
              echo $date_b;
            ?>
           <hr>
           <?php $date_a = date_create($date_from) ?>
           <?php while (true) {
             if ($date_b == $date_from) {
                 $date_contain[] = date_format($date_a,'Y-m-d');
                 break;
             }else{
               $date_contain[] = date_format($date_a,'Y-m-d');
               $date_a =   date_add($date_a, date_interval_create_from_date_string('1 month'));
               $date_compare = date_format($date_a,'Y-m-d');
               if ($date_compare == $date_b) {
                   $date_contain[] = date_format($date_a,'Y-m-d');
                   break;
               }
             }

              $a = $a +1;
              if ($a == 30) {
                echo 'emergency break loop';
                break;
              }

           } ?>
           <?php foreach ($custFileDistinct as $key => $value): ?>
             <div class="table-responsive">
               <table class="table table-bordered">
                 <thead>
                   <th></th>
                   <th style="width:20%"><?php echo $value->customer_name ?></th>
                   <?php foreach ($date_contain as $dates): ?>
                     <th>
                       <?php $display_date = date('M-Y',strtotime($dates)); echo $display_date; ?>
                     </th>
                   <?php endforeach; ?>
                   <th>Total Qty</th>
                 </thead>
                 <tbody>
                   <?php $file = InvoicePerformance::find()->select(['item_name','item_code'])->distinct()
                     ->andFilterWhere(['between','date',$date_from,$date_to])
                     ->andFilterWhere(['like', 'customer_name', $value->customer_name])
                     ->andFilterWhere(['like', 'item_code',$searchModel->item_code])
                     ->andFilterWhere(['like', 'item_name',$searchModel->item_name])
                     ->all();
                    ?>
                    <?php foreach ($file as $key_a => $value_a): ?>
                      <tr>
                        <td style="width:5%"><?php echo $number?></td>
                        <td style="width:20%"><?php echo $value_a->item_code. ' - '. $value_a->item_name ?></td>
                        <?php foreach ($date_contain as $dates): ?>
                          <?php $date_start = date('Y-m-01',strtotime($dates)); ?>
                          <?php $date_end = date('Y-m-t',strtotime($dates)); ?>
                          <?php $month_total =  InvoicePerformance::find()->where(['item_code'=>$value_a->item_code,'item_name'=>$value_a->item_name, 'customer_name'=>$value->customer_name])
                                          ->andFilterWhere(['between','date',$date_start,$date_end])
                                          ->sum('quantity'); ?>
                          <td>
                            <?php if (!empty($month_total)) {
                                echo $month_total;
                            }else{
                                echo 0;
                            }?>
                          </td>
                        <?php endforeach; ?>
                        <?php $total =  InvoicePerformance::find()->where(['item_code'=>$value_a->item_code,'item_name'=>$value_a->item_name, 'customer_name'=>$value->customer_name])
                                        ->andFilterWhere(['between','date',$date_from,$date_to])
                                        ->sum('quantity'); ?>
                        <td>
                        <?php
                          if (!empty($total)) {
                              echo $total;
                          }else{
                            echo 0;
                          }
                        ?>
                        </td>
                      </tr>

                    <?php $number += 1 ?>
                    <?php endforeach; ?>
                    <?php $number = 1; ?>
                 </tbody>
               </table>
             </div>

           <?php endforeach; ?>
          <?php endif; ?>

        </div>
    </div>
  </div>
</div>
