<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\models\InvoicePerformance;
use backend\models\Expenses;
use backend\models\AssetType;
use backend\models\BoilerSum;
use backend\models\Boiler;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoicePerformanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice Performances';
$this->params['breadcrumbs'][] = $this->title;
$total_expenses = 0;
?>
<div class="invoice-performance-index">
<?php $form = ActiveForm::begin(['id' => 'invoice-performance']); ?>

    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Search</h3>
        </div>
        <div class="box-body">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>


    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
              <!--Income Table-->
              <table class="table table-bordered income-table">
                <thead>
                  <th colspan="2">Income</th>
                </thead>
                <tr>
                  <td colspan="2">Sales</td>
                </tr>
                <tr>
                  <td>Sales Coffee</td>
                  <td>
                    <?php $sCoffee = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
                          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                          ->andFilterWhere(['item_abbr'=>'C'])
                          ->sum('amount');
                          if ($sCoffee ==null) {
                            echo 0;
                          }else{
                            echo $sCoffee;
                          }

                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Sales Tea</td>
                  <td>
                    <?php $sTea = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
                          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                          ->andFilterWhere(['item_abbr'=>'T'])
                          ->sum('amount');
                          if ($sTea ==null) {
                            echo 0;
                          }else{
                            echo $sTea;
                          }
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Sales Mug</td>
                  <td>
                    <?php $sMug = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
                          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                          ->andFilterWhere(['item_abbr'=>'M'])
                          ->sum('amount');
                          if ($sMug ==null) {
                            echo 0;
                          }else{
                            echo $sMug;
                          }

                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Sales Others</td>
                  <td>
                    <?php $sOther = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
                          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                          ->andFilterWhere(['!=','item_abbr','C'])
                          ->sum('amount');
                          if ($sOther ==null) {
                            echo 0;
                          }else{
                            echo $sOther;
                          }
                          ?>
                  </td>
                </tr>
                <tr>
                  <td><strong>Total Income</strong></td>
                  <td>
                    <?php $sTotal = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
                          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                          //->andFilterWhere(['!=','item_abbr','M'])
                          ->sum('amount');
                          echo $sTotal;
                        ?>
                  </td>
                </tr>
              </table>

              <!--Cost of sales Table-->
              <table class="table table-bordered cost-table">
                <thead>
                  <th colspan="2">Cost of Sales</th>
                </thead>
                <tr>
                  <td colspan="2">Cost of Sales</td>
                </tr>
                <tr>
                  <td>Cost of Goods Coffee</td>
                  <td>
                    <?php $cCoffee = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
                          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                          ->andFilterWhere(['item_abbr'=>'C'])
                          ->sum('average_cost');

                          if ($cCoffee ==null) {
                            echo 0;
                          }else{
                            echo $cCoffee;
                          }

                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Cost of Goods Tea</td>
                  <td>
                    <?php $cTea = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
                          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                          ->andFilterWhere(['item_abbr'=>'T'])
                          ->sum('average_cost');
                          if ($cTea ==null) {
                            echo 0;
                          }else{
                            echo $cTea;
                          }
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Cost of Goods Mug</td>
                  <td>
                    <?php $cMug = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
                          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                          ->andFilterWhere(['item_abbr'=>'M'])
                          ->sum('average_cost');
                          if ($cMug ==null) {
                            echo 0;
                          }else{
                            echo $cMug;
                          }

                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Cost of Goods Others</td>
                  <td>
                    <?php $cOther = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
                          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                          ->andFilterWhere(['!=','item_abbr','C'])
                          ->sum('average_cost');
                          if ($cOther ==null) {
                            echo 0;
                          }else{
                            echo $cOther;
                          }
                          ?>
                  </td>
                </tr>
                <tr>
                  <td><strong>Total Cost of Sales </strong></td>
                  <td>
                    <?php $cTotal = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])
                          ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                          //->andFilterWhere(['!=','item_abbr','M'])
                          ->sum('average_cost');
                          echo $cTotal;
                        ?>
                  </td>
                </tr>
              </table>

              <!--Cost of Gross Table-->
              <table class="table table-bordered gross-table">
                <tr>
                  <td><strong>Gross Profit</strong></td>
                  <td>
                    <?php $gProfit = $sTotal - $cTotal;
                    echo $gProfit;
                    ?>
                  </td>
                </tr>
              </table>

              <!--Expenses Table-->
              <table class="table table-bordered boiler-table">
                <tr>
                  <td><strong>Share Expenses Amount</strong></td>
                  <td>
                    <?php $expense = Expenses::find()->where(['between','month',$date_from,$date_to])->sum('total');
                      if (!empty($expense)) {
                        echo $expense;
                        $total_expenses += $expense;
                      }else {
                        echo 0;
                      }


                    ?>
                  </td>
                </tr>
                <?php $assets = AssetType::find()->all() ?>
                <?php foreach ($assets as $key => $value): ?>
                  <tr>
                    <td><?php echo $value->asset ?></td>
                    <td>
                      <?php if ($value->asset == 'Boiler'): ?>
                        <?php $boiler = BoilerSum::find()->andFilterwhere(['between', 'boiler_date', $date_from,$date_to])
                                 ->andFilterWhere(['customer'=>$searchModel->customer_name])
                                   ->sum('total_dep_amount');
                              if (!empty($boiler)) {
                                echo $boiler;
                                $total_expenses += $boiler;
                              }else{
                                echo 0;
                              }
                         ?>

                      <?php else: ?>
                        <?php $expenses = Boiler::find()->andFilterWhere(['asset_type'=>$value->id])
                              ->andFilterwhere(['between', 'pur_date', $date_from,$date_to])
                              ->andFilterWhere(['customer'=>$searchModel->customer_name])
                             ->sum('amount');

                             if (!empty($expenses)) {
                               echo $expenses;
                                $total_expenses += $expenses;
                             }else{
                               echo 0;
                             }

                         ?>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <tr>
                  <td><strong>Total Expenses</strong></td>
                  <td><?php echo  $total_expenses?></td>
                </tr>
              </table>

              <!--Net profit Table--->
              <table class="table table-bordered boiler-table">
                <tr>
                  <td><strong>Net Profit</strong></td>
                  <td>
                    <?php $nProfit = $gProfit - $total_expenses;
                      echo $nProfit;
                    ?>
                  </td>
                </tr>
              </table>

                <!--Percentage of individual total vs total salese--->
              <table class="table table-bordered boiler-table">
                <tr>
                  <td>Percentage of individual total vs total sales</td>
                  <td></td>
                </tr>
              </table>

            </div>
        </div>
    </div>


<?php ActiveForm::end(); ?>
</div>
