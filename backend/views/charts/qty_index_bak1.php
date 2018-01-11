<?php
use yii\helpers\Html;
use backend\models\InvoicePerformance;
use dosamigos\chartjs\ChartJs;
$this->title = 'Quantity Chart';
$this->params['breadcrumbs'][] = $this->title;


$ym_from = $searchModel->month_from.'-'.$searchModel->year_from;
$ym_to = $searchModel->month_to.'-'.$searchModel->year_to;
$date_from = date('Y-m-01', strtotime($ym_from));
$date_to = date('Y-m-t', strtotime($ym_to));
$labels = [];
$quantity = [];

function set_rgb(){
  $r = rand(1,255);
  $g = rand(1,255);
  $b = rand(1,255);
  return'rgb('.$r.','.$g.','.$b.')';
}
?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Search</h3>
  </div>
  <div class="box-body">
      <?php  echo $this->render('qty_search', ['model' => $searchModel]); ?>
  </div>
</div>


<?php if (!empty($searchModel->customer_name)): ?>
  <?php foreach ($searchModel->customer_name as $key => $value): ?>
    <?php $labels[] = $value ?>
    <?php $qty = InvoicePerformance::find()->where(['between','date',$date_from,$date_to])
        ->andWhere(['customer_name'=>$value])
        ->sum('quantity'); ?>
    <?php $quantity[] = $qty ?>
  <?php endforeach; ?>
<?php endif; ?>


<?php

  $dataset = [
    'label'=>$labels,
    'dataset'=>['data'=>$quantity]
  ]
 ?>

<?php if (!empty($searchModel->customer_name)): ?>

    <div class="box box-success charts">
      <div class="box-body">
        <?= ChartJs::widget([
          'type' => 'horizontalBar',
          'options' => [
              'height' => 200,
              'width' => 400,
          ],
          'clientOptions'=>[
            'title'=>['text'=>'Total Quantity', 'display'=>true],
          ],
          'data' => [
              'labels' => $labels,
              'datasets' => [
                  [
                      'backgroundColor'=>set_rgb(),
                      'data' => $quantity,
                      'label'=>'Quantity',
                  ],
              ]

          ]

      ]);
      ?>
      </div>
    </div>
<?php endif; ?>
