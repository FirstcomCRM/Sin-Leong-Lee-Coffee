<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use dosamigos\highcharts\HighCharts;
use backend\models\InvoicePerformance;



$avg_cof = 0;
$total_cost = 0;
$grossProfit = 0;

$ym_from = $searchModel->month_from.'-'.$searchModel->year_from;
$ym_to = $searchModel->month_to.'-'.$searchModel->year_to;
$date_from = date('Y-m-01', strtotime($ym_from));
$date_to = date('Y-m-t', strtotime($ym_to));

$amount = (int)InvoicePerformance::find()->where(['between','date',$date_from,$date_to])
        ->andWhere(['customer_name'=>$searchModel->customer_name])
        ->sum('amount');

$arrCost = InvoicePerformance::find()->where(['between','date',$date_from,$date_to])
        ->andWhere(['customer_name'=>$searchModel->customer_name])
        ->all();

foreach ($arrCost as $key => $value) {
    $avg_cof = $value->quantity * $value->average_cost;
    $total_cost += $avg_cof;
}

$grossProfit = $amount - $total_cost;
$chartData[] =$grossProfit;

$avg_cof = 0;
$total_cost = 0;
$grossProfit = 0;

//print_r (gettype((int)number_format($grossProfit))).'<br>';
//echo (int)number_format($grossProfit);
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

<?php if ($amount != 0): ?>
  <div class="charts">
    <?php echo
    HighCharts::widget([
        'clientOptions' => [
            'chart' => [
                    'type' => 'bar'
            ],
            'title' => [
                 'text' => 'Gross Profit'
                 ],

            'series' => [
                ['name' => $searchModel->customer_name, 'data' => $chartData],
              //    ['name' => $searchModel->customer_name, 'data' => $chartData],
              //  ['name' => 'John', 'data' => [5, 7, 3]]
            ]
        ]
    ]);

    ?>
  </div>
<?php endif; ?>

<?php
  $test =  [
      ['name' =>'josepf', 'data' => [6]],
      ['name' => 'Johnson', 'data' => [7]],
    ];

  print_r($test);
 ?>


<div class="charts">
  <?php echo
  HighCharts::widget([
      'clientOptions' => [
          'chart' => [
                  'type' => 'bar'
          ],
          'title' => [
               'text' => 'Data Testing'
               ],

              'series' => $test//[
                    //for ($i=0; $i <2 ; $i++) {
              //    ['name' =>[customer1,customer2], 'data' => $data],
            //    ['name' => 'Johnson', 'data' => [7]],
        //     ['name' => 'John', 'data' => [5]],

        //    }
              //]


      ]
  ]);

  ?>
  </div>


<hr>
<?php
$customers = ['147 Serangoon Food House Pte Ltd','16 Hot Cold Beverage','211 New Upper Changi Drink'];
foreach ($customers as $value) {
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


<?php print_r(gettype($searchModel->customer_name)) ?>

  <div class="charts">
    <?php echo
    HighCharts::widget([
        'clientOptions' => [
            'chart' => [
                    'type' => 'bar'
            ],
            'title' => [
                 'text' => 'New Test'
                 ],

            'series' => $series//[
                //['name' => $searchModel->customer_name, 'data' => $chartData],
                //  ['name' => $searchModel->customer_name, 'data' => $chartData],
              //  ['name' => 'John', 'data' => [5, 7, 3]]
            //],
        ]
    ]);

    ?>
  </div>
