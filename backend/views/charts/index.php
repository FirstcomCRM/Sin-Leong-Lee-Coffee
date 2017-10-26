<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use dosamigos\highcharts\HighCharts;
use backend\models\InvoicePerformance;

$avg_cof = 0;
$total_cost = 0;
$grossProfit = 0;
$series = null;

$ym_from = $searchModel->month_from.'-'.$searchModel->year_from;
$ym_to = $searchModel->month_to.'-'.$searchModel->year_to;
$date_from = date('Y-m-01', strtotime($ym_from));
$date_to = date('Y-m-t', strtotime($ym_to));

$this->title = 'Performance Chart';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Search</h3>
  </div>
  <div class="box-body">
      <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
  </div>
</div>


<?php if (!empty($searchModel->customer_name)): ?>
  <?php
    foreach ($searchModel->customer_name as $value) {
      $name = $value;
      $amount = InvoicePerformance::find()->where(['between','date',$date_from,$date_to])
          ->andWhere(['customer_name'=>$value])
          ->sum('amount');
      $arrCost = InvoicePerformance::find()->where(['between','date',$date_from,$date_to])
              ->andWhere(['customer_name'=>$value])
              ->all();
      foreach ($arrCost as $key => $value) {
            $avg_cof = $value->quantity * $value->average_cost;
            $total_cost += $avg_cof;
          }
      $data = $amount - $total_cost;
      $series[] =['name' =>$name, 'data' => [$data]];

      $data = 0;
      $total_cost = 0;
      $avg_cof = 0;
      $amount = 0;
    } 

   ?>

     <div class="charts">
       <?php echo
       HighCharts::widget([
           'clientOptions' => [
               'chart' => [
                       'type' => 'bar'
               ],
              // 'xAxis'=>[
              //   'categories'=>['test','dollar2'],
               //],
               'title' => [
                    'text' => 'Gross Profit'
                    ],
               'series' => $series

           ]
       ]);

       ?>
     </div>

<?php endif; ?>
