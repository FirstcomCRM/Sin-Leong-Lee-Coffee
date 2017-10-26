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
           <h6>Origin Date:</h6> <?php echo $date_from ?>
           <hr>
           <table class="table table-bordered">
             <thead>
               <th>Date start</th>
               <th>Date end</th>
               <?php $date_from = date_create($date_from) ?>
               <?php $protoDate = date_format($date_from,'Y-m-d') ?>

                 <?php $protoss = date('Y-m-t', strtotime($protoDate)); ?>
                 <?php echo $protoss ?>
             </thead>
             <?php foreach ($variable as $key => $value): ?>

             <?php endforeach; ?>
             <?php for ($i=0; $i < 5; $i++) {

               echo "<tr>";
               echo "<td>{$protoDate}</td>";
               echo "<td>{$protoss}</td>";
               echo '</tr>';
               $protoDate =   date_add($date_from, date_interval_create_from_date_string('1 month'));
             $protoDate = date_format($protoDate,'Y-m-d');
             $protoss = date('Y-m-t', strtotime($protoDate));
             } ?>
          </table>
          <?php endif; ?>
        </div>
    </div>
  </div>
</div>
